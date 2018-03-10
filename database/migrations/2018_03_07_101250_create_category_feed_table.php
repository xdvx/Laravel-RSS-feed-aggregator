<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_feed', function (Blueprint $table) {
            $table->integer('feed_id');
            $table->integer('category_id');
            $table->timestamps();

            $table->unique(['category_id', 'feed_id']);
            $table->foreign('feed_id')->references('id')->on('feeds')->delete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_feed');
    }
}
