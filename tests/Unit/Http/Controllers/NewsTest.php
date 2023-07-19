<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\TestCase;

namespace Tests\Feature\Http\Controllers;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\news;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class NewsTest extends TestCase
{


    use DatabaseTransactions;

    


    ////////////////////////////////////////////////////////////////////
    ///////////////////////    SHOW AND LIST    ////////////////////////
    ////////////////////////////////////////////////////////////////////


    public function test_show_successfully()
    {

        $news = news::factory()->create();

        $response = $this->get(route('news.show', ['news' => $news]));
        $this->withoutExceptionHandling();

        $response->assertStatus(200);
    }

    public function test_index_successfully()
    {


        $response = $this->get(route('news.index'));
        $this->withoutExceptionHandling();
        $response->assertStatus(200);

    }




    ////////////////////////////////////////////////////////////////////
    ///////////////////////    STORE   NEWS  ///////////////////////////
    ////////////////////////////////////////////////////////////////////



    public function test_store_news_successfully()
    {


        $response = $this->post(route('news.store'), [
            'title' => $this->uniqetitle,
            'pre_description' => 'توضیح جدید است این تکراری نیست',
            'body' => 'شسشسیشسیشسیشسیشسییشسیشسی'
        ]);

        $this->withoutExceptionHandling();

        $response->assertStatus(200);

    }

    public function test_store_validation_title_tekrari()
    {



        $news = news::factory()->create();

        $response = $this->post(route('news.store'), [
            'title' => $news->title,
            'pre_description' => "این توضیح جیدی است و تکراری نیست",
            'body' => 'بدنه ی خبررررر',
        ]);


        $this->withoutExceptionHandling();
        $response->assertStatus(422);


    }


    public function test_store_validation_data_khali()
    {

        $response = $this->post(route('news.store'), []);
        $this->withoutExceptionHandling();
        $response->assertStatus(422);

    }

    public function test_store_validation_english_data()
    {

        $response = $this->post(route('news.store'), [
            'title' => 'farsi nist ttile',
            'pre_description' => 'descccccccc',
            'body' => 'english body',
            'tags' => 'سهیل , خبر جدید , حبرررر'
        ]);
        $this->withoutExceptionHandling();
        $response->assertStatus(422);

    }





    ////////////////////////////////////////////////////////////////////
    ///////////////////////    UPDATE  NEWS  ///////////////////////////
    ////////////////////////////////////////////////////////////////////


    public function test_update_news_validation_empty_data()
    {
        $news = news::factory()->create();

        $response = $this->Json("PUT", route('news.show', ['news' => $news]), []);

        $this->withoutExceptionHandling();

        $response->assertStatus(422);

    }
    public function test_update_news_fail_title_tekrari()
    {
        $news = news::factory()->create();

        $news2 = news::factory()->create();


        $response = $this->Json("PUT", route('news.show', ['news' => $news]), [
            'title' => $news2->title,
            'pre_description' => 'توضیح جدید است این تکراری نیست',
            'body' => 'شسشسیشسیشسیشسیشسییشسیشسی'
        ]);

        $this->withoutExceptionHandling();

        $response->assertStatus(422);

    }


    public function test_update_news_success()
    {
        $news = news::factory()->create();




        $response = $this->Json("PUT", route('news.show', ['news' => $news]), [
            'title' => $this->uniqetitle,
            'pre_description' => 'توضیح جدید است این تکراری نیست',
            'body' => 'شسشسیشسیشسیشسیشسییشسیشسی'
        ]);

        $this->withoutExceptionHandling();

        $response->assertStatus(200);

    }

    public function test_update_validation_english_data()
    {
        $news = news::factory()->create();

        $response = $this->Json("PUT", route('news.update', ['news' => $news]), [
            'title' => 'farsi nist ttile',
            'pre_description' => 'descccccccc',
            'body' => 'english body',
            'tags' => 'سهیل , خبر جدید , حبرررر'
        ]);
        $this->withoutExceptionHandling();
        $response->assertStatus(422);

    }



    ////////////////////////////////////////////////////////////////////
    ///////////////////////    DESTROY NEWS  ///////////////////////////
    ////////////////////////////////////////////////////////////////////




    public function test_destroy()
    {
        $news = news::factory()->create();

        $response = $this->Json("DELETE", route('news.destroy', ['news' => $news]));
        $this->withoutExceptionHandling();
        $response->assertStatus(200);
    }


    ////////////////////////////////////////////////////////////////////
    ///////////////////////   REACTION NEWS  ///////////////////////////
    ////////////////////////////////////////////////////////////////////


    public function test_reaction_news_success()
    {
        $news = news::factory()->create();

        $response = $this->post(
            route('reactionToNews', ['news' => $news]),
            [
                'reaction' => '1'
            ]
        );
        $this->withoutExceptionHandling();
        $response->assertStatus(200);
    }

    public function test_reaction_news_fail_number_eshtebah()
    {
        $news = news::factory()->create();

        $response = $this->post(
            route('reactionToNews', ['news' => $news]),
            [
                'reaction' => '5'
            ]
        );
        $this->withoutExceptionHandling();
        $response->assertStatus(422);
    }



}