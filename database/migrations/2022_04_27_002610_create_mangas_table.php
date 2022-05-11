<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('name')->unique();
            $table->string('author');
            $table->text('desc');
            $table->boolean('ongoing')->default(true);
            $table->string('genres');
            $table->string('cover')->unique();
            $table->foreignId('id_scanlator')->nullable()->default(null)->constrained('scanlators');
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
        Schema::dropIfExists('mangas');

        //clean storage
        $dirs = Storage::disk('public')->allDirectories();
        foreach($dirs as $dir) {
            Storage::deleteDirectory($dir);
        }
    }
};
