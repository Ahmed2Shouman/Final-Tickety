<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->nullable()->constrained('halls');
            $table->integer('seat_row')->nullable();
            $table->integer('seat_column')->nullable();
            $table->enum('seat_type', ['Standard', 'VIP'])->default('Standard');
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
        Schema::dropIfExists('seats');
    }
}
