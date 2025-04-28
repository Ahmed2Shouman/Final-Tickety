<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSeatIdToSeatsInBookingsTable extends Migration
{
 public function up()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['seat_id']); // Drop foreign key if exists
        $table->dropColumn('seat_id');    // Remove seat_id column
        $table->json('seats')->after('showtime_id'); // Add seats as JSON
    });
}
//database\migrations\2025_04_21_221618_update_seat_id_to_seats_in_bookings_table.php
public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn('seats');
        $table->unsignedBigInteger('seat_id')->after('showtime_id');
        $table->foreign('seat_id')->references('id')->on('seats');
    });
}

}
