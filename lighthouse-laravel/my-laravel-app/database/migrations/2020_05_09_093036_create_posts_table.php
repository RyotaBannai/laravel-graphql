<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id(); //$table->primary('id');
            $table->integer('user_id');
            $table->string('title', 100);
            $table->longText('content');
            $table->string('category', 100)->nullable();
            $table->timestamps(); // NULL値可能なcreated_atとupdated_atカラム追加
            $table->softDeletes(); // ソフトデリートのためにNULL値可能なdeleted_at TIMESTAMPカラム
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
