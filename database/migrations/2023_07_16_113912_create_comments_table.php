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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();



            $table->string('ip');

            $table->foreignId('news_id');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');


            $table->foreignId('answered_to')->nullable();
            $table->foreign('answered_to')->references('id')->on('comments')->onDelete('cascade')->nullable();

            $table->foreignId('main_parent')->nullable();
            $table->foreign('main_parent')->references('id')->on('comments')->onDelete('cascade')->nullable();


            $table->string('writer' , 100);
            $table->text('comment_body' , 500);

            $table->string('status')->default('new');

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
        Schema::dropIfExists('comments');
    }
};
