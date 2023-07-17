<?php

namespace App\Http\Controllers;

use App\Http\Requests\acceptCommentReq;
use App\Http\Requests\CommentReactionReq;
use App\Models\comments;
use App\Http\Requests\StorecommentsRequest;
use App\Http\Requests\UpdatecommentsRequest;
use App\Models\news;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;


class CommentsController extends Controller
{


    public function store(StorecommentsRequest $request)
    {



        try {

            //check if parent comment is exactly is for this news when user wants to answer comment

            if ($request->answered_to) {

                $parentComment = comments::findOrFail($request->answered_to);


                if ($parentComment->news_id != $request->news_id) {
                    return $this->error("bad data !!!   this comment is not for this news", 402);
                }


                //when user want to answer the not accepted comment
                if (!$parentComment->acceptedStatus()) {
                    return $this->error("bad data  !!!   You want to answer to not accepted comment ... please accept parent comment and then answer that", 402);
                }


                if (is_null($parentComment->main_parent)) {
                    $main_parent = $parentComment->id;
                } else {
                    $main_parent = $parentComment->main_parent;
                }
            } else {
                $main_parent = null;
            }




            //check if user sent a comment in last 2 minute
            $lastCommetInlastTwoMinutes = comments::where('news_id', $request->news_id)
                ->ip($request->ip())
                ->availableTimes()
                ->first();

            if ($lastCommetInlastTwoMinutes) {


                $Comment_created_at = Carbon::parse($lastCommetInlastTwoMinutes->created_at)->addMinutes(2);

                $diffSeconds = $Comment_created_at->diffInSeconds(Carbon::now());

                $massage = "you recently have been send a comment for this news !!!!  you must send your new commnet in : " . $diffSeconds . " seconds later";

                return $this->error($massage, 402);
            }



            $data = array_merge($request->only([
                'news_id',
                'answered_to',
                'writer',
                'comment_body'
            ]), ['ip' => \Request::ip(), 'main_parent' => $main_parent]);




            comments::create($data);

            return $this->Success("comment saved successfully and it will be release after accept");
        } catch (Exception $e) {

            return $this->error($e, 402);
        }
    }

    public function acceptComment(comments $comment)
    {
        try {

            if ($comment->acceptedStatus()) {
                return $this->error('you have been acceptewd this comment', 402);
            }


            if (!$comment->acceptParentStatus()) {
                return $this->error('  this comment has a parent that you did not accept that ...  you must accept this comment`s parent and after that you can accept it !!!', 402);
            }

            $comment->accept();

            $comment->news->increaseCommentCount();
        } catch (Exception $e) {

            return $this->error($e, 402);
        }
    }


    public function destroy(comments $comment)
    {

        try {

            $comment->deleteCommentAndDeleteItsAnswers();

            return $this->Success("comment deletsd !!!");
        } catch (Exception $e) {
            return $this->error($e, 402);
        }
    }


    public function reactionToComment(CommentReactionReq $request)
    {

        $comment = comments::find($request->comment_id);

        if (!$comment->acceptedStatus()) {
            return $this->error("bad data  !!!   You want to react to not accepted comment ... please accept parent comment and then react that", 402);

        }
        $msg  =  $comment->submitReaction($request->reaction, $request->ip());

        return $this->Success($msg);
    }
}
