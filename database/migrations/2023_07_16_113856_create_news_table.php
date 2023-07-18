<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();



            $table->string('image');

            $table->string('title' , 50);

            $table->string('slug' , 50);

            $table->string('pre_description' , 100);
            $table->longText('body');
            $table->unsignedBigInteger('viewCount')->default(0);
            $table->unsignedBigInteger('commentCount')->default(0);


            
            $table->unsignedInteger('likes')->default(0);
            $table->unsignedInteger('disslikes')->default(0);


            $table->longText('likeOrDisslikeJsonData')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
