<?php

namespace App\Http\Controllers;

use App\Models\tags;
use App\Http\Requests\StoretagsRequest;
use App\Http\Requests\UpdatetagsRequest;
use App\Models\news;
use App\Models\news_tags;

class TagsController extends Controller
{


    public function saveTagsAndConnectToNews(array $tags, news $news)
    {
        foreach ($tags as $value) {


            $tag = tags::firstOrCreate(['name' => $value]);

            $tag->increaseNewsCount();

            $news_tags = news_tags::firstOrCreate([
                'news_id' => $news->id,
                'tags_id' => $tag->id
            ]);
        }
    }
}
