<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_tags extends Model
{
    use HasFactory;
    protected $table = 'news_tags';
    protected $fillable = ['news_id' , 'tags_id'];



}

