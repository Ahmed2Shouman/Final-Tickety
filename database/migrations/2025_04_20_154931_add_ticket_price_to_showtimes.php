// In the migration file:
public function up()
{
    Schema::table('showtimes', function (Blueprint $table) {
        $table->decimal('ticket_price', 8, 2)->default(12.00); // Set a default price, e.g., 12.00
    });
}<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketPriceToShowtimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
// In the migration file:
public function up()
{
    Schema::table('showtimes', function (Blueprint $table) {
        $table->decimal('ticket_price', 8, 2)->default(12.00); // Set a default price, e.g., 12.00
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
public function down()
{
    Schema::table('showtimes', function (Blueprint $table) {
        $table->dropColumn('ticket_price');
    });
}
}
