<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\comments>
 */
class CommentsFactory extends Factory
{
    
    //  private $newsId ;
    //  private $answered_to;

    // public function __construct($newsId , $answered_to = null){

    //     $this->newsId = $newsId;
    //     $this->answered_to = $answered_to;
    // }

    public function definition(): array
    {
        return [
            // 'news_id'=>$this->newsId ,
            // 'answered_to'=>$this->answered_to ,
            'writer'=>'soheil',
            'comment_body'=>'لایککککک',
        ];
    }
}
