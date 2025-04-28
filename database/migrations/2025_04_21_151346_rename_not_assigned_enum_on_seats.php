<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;
class RenameNotAssignedEnumOnSeats extends Migration
{
 public function up()
    {
        // 1️⃣ First, update existing data
        DB::table('seats')
            ->where('seat_type', 'Not Assigned')
            ->update(['seat_type' => 'not_assigned']);

        // 2️⃣ Then modify the enum definition
        Schema::table('seats', function (Blueprint $table) {
            $table->enum('seat_type', [
                    'vip',
                    'standard',
                    'not_assigned'
                ])
                ->default('not_assigned')
                ->change();
        });
    }

    public function down()
    {
        // reverse: put data back, then revert enum to include the old string
        DB::table('seats')
            ->where('seat_type', 'not_assigned')
            ->update(['seat_type' => 'Not Assigned']);

        Schema::table('seats', function (Blueprint $table) {
            $table->enum('seat_type', [
                    'vip',
                    'standard',
                    'Not Assigned'
                ])
                ->default('Not Assigned')
                ->change();
        });
    }
}
