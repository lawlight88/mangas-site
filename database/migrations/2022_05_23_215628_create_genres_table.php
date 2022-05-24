<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('genre_key')->unsigned();

            $table->integer('id_manga')->unsigned();
            $table->foreign('id_manga')->references('id')->on('mangas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('genres');
    }
};
