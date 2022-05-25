<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');

            $table->integer('id_manga')->unsigned();
            $table->foreign('id_manga')->references('id')->on('mangas');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};
