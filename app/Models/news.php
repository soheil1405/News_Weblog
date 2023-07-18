<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;


    protected $table = "news";

    protected $fillable = [
        'title',
        'pre_description',
        'body',
        'image',
        'slug',
        'viewCount',
        'commentCount',

    ];


    public function comments()
    {
        return $this->hasMany(comments::class);
    }

    public function availableComments()
    {
        return $this->hasMany(comments::class)->where('status', 'yes')->whereNull('answered_to');
    }



    public function increaseViewCount()
    {

        $this->update([
            'viewCount' => $this->viewCount + 1
        ]);
    }


    public function increaseCommentCount()
    {

        $this->update([
            'commentCount' => $this->commentCount + 1
        ]);
    }

    public function tags()
    {
        return $this->belongsToMany(tags::class, 'news_tags');
    }


    public function deleteComments()
    {
        $comments = $this->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }
    }

    public function decreaseTagsNewsCount()
    {

        $tags = $this->tags;

        foreach ($tags as $tag) {
            $tag->DecreaseNewsCount();
        }
    }

    public function brokeRelationsToTags()
    {
        $this->tags()->detach();
    }



    public function submitReaction($reaction, $ip)
    {

        $reactionStatus = checkIfValueExistsInJson($ip, $this->likeOrDisslikeJsonData, $reaction);




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

    
    public function reactionStatus($ip)
    {

        $status = checkIfValueExistsInJson($ip, $this->likeOrDisslikeJsonData, null);

        return $status;
    }
}