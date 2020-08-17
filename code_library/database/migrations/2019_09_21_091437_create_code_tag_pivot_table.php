<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('code_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('code_id')->unsigned();
            $table->Integer('tag_id')->unsigned();

            $table->foreign('code_id')->references('id')->on('codes')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('code_tag');
    }
}
