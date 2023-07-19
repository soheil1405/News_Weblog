<?php

namespace Tests\Unit\Http\Controllers;

use PHPUnit\Framework\TestCase;

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
class NewsTest extends TestCase
{

    public function test_index_successfully(){

        
        $response = $this->get(route('news.index'));
        $this->withoutExceptionHandling();
        $response->assertStatus(200);

    }


    public function test_store_successfully(){

        
        $response = $this->post(route('news.store') , [
            'title' =>'عنوان خبر جدید' ,
            'pre_description'=>'متن پیش نمایش خبر جدیدددددددددددددد' ,
            'body'=>'بدنه ی خبرررررررررررررررررررررر',
        ]);


        $this->withoutExceptionHandling();
        $response->assertStatus(200);


    }

}
