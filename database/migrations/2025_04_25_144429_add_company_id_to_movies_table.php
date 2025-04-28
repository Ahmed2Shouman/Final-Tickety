<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToMoviesTable extends Migration
{
public function up()
{
    Schema::table('movies', function (Blueprint $table) {
        $table->unsignedBigInteger('company_id')->nullable();

        // If you want to set a foreign key constraint to link to the companies table:
        $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            //
        });
    }
}
