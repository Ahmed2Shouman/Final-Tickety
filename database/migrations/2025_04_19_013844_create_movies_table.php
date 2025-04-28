<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Movies Table
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250)->nullable();
            $table->text('description')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->string('genre', 50)->nullable();
            $table->string('rating', 10)->nullable();
            $table->string('poster_url', 250)->nullable();
            $table->string('trailer_url', 250)->nullable();
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
        Schema::dropIfExists('movies');
    }
}
