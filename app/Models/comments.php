<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{

    use HasFactory;


    protected $table = "comments";


    protected $fillable = [
        'news_id',
        'answered_to',
        'writer',
        'ip',
        'likes',
        'disslikes',
        'likeOrDisslikeJsonData',
        'comment_body',
        'status',
        'main_parent'
    ];




    public function news()
    {
        return $this->belongsTo(news::class);
    }

    public function accept()
    {
        $this->update([
            'status' => 'yes'
        ]);
    }


    public function parent()
    {
        return $this->belongsTo(comments::class, 'answered_to');
    }

    public function mainParent()
    {

        return $this->belongsTo(comments::class, 'main_parent');
    }

    public function answers()
    {
        return $this->hasMany(comments::class, 'main_parent');
    }

    public function availableAnswers()
    {
        return $this->hasMany(comments::class, 'main_parent')->where('status', 'yes');
    }
    public function acceptedStatus()
    {
        if ($this->status == "new") {
            return false;
        } else {
            return true;
        }
    }

    public function acceptParentStatus()
    {
        if ($this->parent && $this->parent->status == "new") {
            return false;
        } else {
            return true;
        }
    }

    public function deleteCommentAndDeleteItsAnswers()
    {

        $newsCommentCount_CountDown = count($this->answers) + 1;

        $this->deleteAnswers();

        $news =  $this->news;

        if ($news) {
            $news->update([
                'commentCount' => $news->commentCount - $newsCommentCount_CountDown
            ]);
        }
        $this->delete();
    }

    public function deleteAnswers()
    {
        $answers = $this->answers;
        foreach ($answers as $answer) {
            $answer->delete();
        }
    }


    public function scopeAvailableTimes($query)
    {
        return $query->where('created_at', ">", Carbon::now()->subMinutes(2));
    }

    public function scopeIp($query, $ip)
    {
        return $query->where('ip', $ip);
    }


    public function submitReaction($reaction, $ip)
    {

        $reactionStatus = checkIfValueExistsInJson($ip, $reaction, $this->likeOrDisslikeJsonData);




        switch ($reactionStatus['status']) {


            case 1:
                $this->likes = ($this->likes + 1);
                $msg = "Liked";
                break;
            case -1:
                $this->disslikes = ($this->disslikes + 1);
                $msg = "dissLiked";
                break;
            case 11:
                $this->likes = ($this->likes + 1);
                $this->disslikes = ($this->disslikes - 1);
                $msg = "your dissLike canceled and liked";

                break;
            case -11:
                $this->likes = ($this->likes - 1);
                $this->disslikes = ($this->disslikes + 1);
                $msg = "your like canceled and dissLiked";
                break;
            case 111:
                $this->likes = ($this->likes - 1);
                $msg = "your like canceled ";
                break;
            case -111:
                $this->disslikes = ($this->disslikes - 1);
                $msg = "your dissLike canceled ";

                break;
            default:
                $msg = "nothing happened";
                break;
        }


        $this->likeOrDisslikeJsonData = $reactionStatus['json'];

        $this->save();

        return $msg;
    }
}
