<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          // Halls Table
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id')->nullable()->constrained('cinemas');
            $table->string('name', 250)->nullable();
            $table->integer('seat_rows')->nullable();
            $table->integer('seat_columns')->nullable();
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
        Schema::dropIfExists('halls');
    }
}
