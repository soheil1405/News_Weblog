<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\news>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


     
    public function definition(): array
    {
        return [
            'title'=>$this->faker->unique()->persianText($maxNBChars = 30)		,
            'pre_description'=>$this->faker->persianText($maxNBChars = 40)		,
            'body'=>$this->faker->persianParagraph(),
            'image'=>env('DEFUALT_NEWS_IMG_NAME')
        ];
    }
}
