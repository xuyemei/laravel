<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('notices',function (Blueprint $table){
            $table->increments('id');
            $table->string('title',50)->default('');
            $table->string('content',1000)->default('');
            $table->timestamps();
        });

        //
        Schema::create('user_notice',function (Blueprint $blueprint){
            $blueprint->increments('id');
            $blueprint->integer('user_id')->default(0);
            $blueprint->integer('notice_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notices');
        Schema::drop('user_notice');
    }
}
