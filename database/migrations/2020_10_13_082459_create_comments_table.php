<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->text('comment');
            $table->unsignedBigInteger('news_id')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
