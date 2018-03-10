<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id');
            $table->string('title');
            $table->text('text');
            $table->string('url');
            $table->integer('url_crc32');
            $table->timestamps();

            $table->index(['feed_id', 'url_crc32']);

            $table->foreign('feed_id')->references('id')->on('feeds');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
