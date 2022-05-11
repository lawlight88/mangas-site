<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_requester')->constrained('scanlators')->onDelete('cascade');

            $table->integer('id_manga')->unsigned();
            $table->foreign('id_manga')->references('id')->on('mangas')->onDelete('cascade');

            $table->boolean('status')->nullable()->default(null);
            $table->boolean('visible_admin')->default(true);
            $table->boolean('visible_scan')->default(true);

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
        Schema::dropIfExists('requests');
    }
};
