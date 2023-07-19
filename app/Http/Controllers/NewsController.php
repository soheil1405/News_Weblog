<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsReactionReq;
use App\Models\news;
use App\Http\Requests\StorenewsRequest;
use App\Http\Resources\NewsIndexResource;
use App\Http\Resources\ShowNewsResource;
use App\Models\tags;
use Exception;
use Illuminate\Http\Request;


class NewsController extends Controller
{

    public function index(Request $request)
    {

        $tagId = $request->tagId;

        if ($tagId) {
            $tag = tags::findOrFail($tagId);

            $news = $tag->news()->paginate(20);
        } else {
            $news = news::select('slug', 'title', 'image', 'pre_description', 'created_at', 'commentCount', 'created_at')->paginate(20);
        }

        return NewsIndexResource::collection($news);
    }


    public function store(StorenewsRequest $request)
    {

        // try {


        $NewsWithSampleTitle = news::where('title', $request->title)->first();

        if ($NewsWithSampleTitle) {
            return $this->error("You has been store a news with same title", 401);
        }

        if ($request->file('image')) {
            $imageName = $this->storeFile('image', $request->file('image'), 's3');
        } else {
            $imageName = env('DEFUALT_NEWS_IMG_NAME');
        }


        $slug = str_replace(" ", "-", $request->title);

        $data = array_merge($request->only(['title', 'pre_description', 'body']), ['image' => $imageName, 'slug' => $slug]);

        $news = news::create($data);


        if ($request->tags) {

            $tags = explode(",", $request->tags);

            resolve(TagsController::class)->saveTagsAndConnectToNews($tags, $news);
        }
        return $this->Success($news);
        // } catch (Exception $e) {
        //     return $this->error("Unexpected Error Happend", 401);
        // }
    }


    public function show(news $news)
    {

        $news->increaseViewCount();

        return new ShowNewsResource($news);
    }


    public function update(StorenewsRequest $request, news $news)
    {


        try {


            $NewsWithSampleTitle = news::where('title', "Like", "%" . $request->title . "%")->where('id', '!=', $news->id)->first();

            if ($NewsWithSampleTitle) {
                return $this->error("You has been store a news with same title", 401);
            }


            if ($request->file('image')) {
                if ($news->image != env('DEFUALT_NEWS_IMG_NAME')) {
                    $this->deleteFile($news->image, 's3');
                }
                $imageName = $this->storeFile('image', $request->file('image'), 's3');
            } else {
                $imageName = $news->image;
            }

            $data = array_merge($request->only(['title', 'pre_description', 'body']), ['image' => $imageName]);

            $news = $news->update($data);

            return $this->Success($news);
        } catch (Exception $e) {

            return $this->error("Unexpected Error Happend", 401);
        }
    }


    public function destroy(news $news)
    {


        try {

            $news->deleteComments();

            $news->decreaseTagsNewsCount();

            $news->brokeRelationsToTags();

            $news->delete();

            return $this->Success('news deleted successfully');

        } catch (Exception $e) {

            return $this->error($e, 402);
        }
    }



    public function reactionToNews(NewsReactionReq $request)
    {


        $news = news::find($request->news_id);

        $msg = $news->submitReaction($request->reaction, $request->ip());

        return $this->Success($msg);
    }
}