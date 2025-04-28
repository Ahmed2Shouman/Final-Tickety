<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('task_name');
        $table->text('description')->nullable();
        $table->boolean('is_completed')->default(false); // Proper boolean flag
        $table->unsignedBigInteger('company_id');
        $table->timestamps();

        // Foreign key constraint
        $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
