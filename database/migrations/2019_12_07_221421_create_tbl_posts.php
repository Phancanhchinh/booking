<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',191);
            $table->string('slug',191);
            $table->longText('content')->nullable();
            $table->longText('image')->nullable()->comment('save multi image type json');
            $table->longText('video')->nullable();
            $table->bigInteger('author_id');
            $table->tinyInteger('status');
            $table->integer('type_post')->default(0);
            $table->integer('number_view')->default(0)->comment('số lượng khách vào xem hàng');
            $table->integer('rate_star')->default(0)->comment('1,2,3,4,5 ông star');
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
        Schema::drop('posts');
    }
}
