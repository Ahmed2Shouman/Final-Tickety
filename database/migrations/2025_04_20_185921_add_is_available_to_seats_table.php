<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAvailableToSeatsTable extends Migration
{
public function up()
{
    Schema::table('seats', function (Blueprint $table) {
        // Add the 'is_available' field with a default value of true (available)
        $table->boolean('is_available')->default(true);
    });
}

public function down()
{
    Schema::table('seats', function (Blueprint $table) {
        // Remove the 'is_available' field if this migration is rolled back
        $table->dropColumn('is_available');
    });
}

}
