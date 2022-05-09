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
        Schema::create('scanlators', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('desc')->nullable()->default(null);
            $table->string('image');
            $table->foreignId('leader')->constrained('users');
            $table->timestamps();
        });
        // 2022_05_08_233109_create_scanlators_table //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scanlators');
    }
};
