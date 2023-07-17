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
}
