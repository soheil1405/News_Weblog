<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class tags extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $fillable = ['name', 'newsCounts'];


    public function news() :BelongsToMany
    {
        return $this->BelongsToMany(news::class , news_tags::class);
    }


    public function increaseNewsCount(){
        $this->update([
            'newsCounts'=>$this->newsCounts +1
        ]);
    }


    public function DecreaseNewsCount(){
        $this->update([
            'newsCounts'=>$this->newsCounts - 1
        ]);

    }

}
