<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'comment',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('member_id')->comment('评论用户id');
                $table->integer('pid')->default(0)->comment('评论对象id');
                $table->string('path')->default('0,')->comment('评论层级');
                $table->string('obj_id')->default('1')->comment('评论对象');
                $table->string('referer_url')->comment('评论来源url');
                $table->text('content')->comment('评论内容');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment');
    }
}
