<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamps();
        });
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->string('info')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('click')->default(0);
            $table->boolean('published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->string('thumb');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('pushes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('msg_id')->unique();
            $table->string('title');
            $table->string('message');
            $table->integer('article_id')->nullable();
            $table->integer('received')->default(0);
            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text')->unique();
            $table->timestamps();
        });
        Schema::create('article_category', function (Blueprint $table) {
            $table->integer('article_id');
            $table->integer('category_id');
            $table->primary(['article_id', 'category_id']);
        });
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key');
            $table->string('value')->nullable();
            $table->timestamps();
        });
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('content')->nullable();
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('commentable');
            $table->string('author');
            $table->string('content');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nikename');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins');
        Schema::drop('articles');
        Schema::drop('pushes');
        Schema::drop('categories');
        Schema::drop('article_category');
        Schema::drop('settings');
        Schema::drop('logs');
        Schema::drop('comments');
        Schema::drop('feedbacks');
    }
}
