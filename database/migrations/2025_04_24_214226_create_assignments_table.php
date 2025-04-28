<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID for the assignment

            // Staff ID - Foreign Key to users table
            $table->unsignedBigInteger('staff_id');
            $table->string('task_name');  // Name of the task
            $table->text('description')->nullable();  // Optional description of the task
            $table->boolean('is_completed')->nullable();  // Nullable, if not completed or not assigned yet
            $table->timestamps();  // For created_at and updated_at timestamps

            // Index the staff_id column for better performance
            $table->index('staff_id');

            // Defining Foreign Key Constraint
            $table->foreign('staff_id')
                  ->references('id')
                  ->on('users')  // Assuming 'users' table is where staff info is stored
                  ->onDelete('cascade')
                  ->onUpdate('cascade');  // Cascade update in case of ID changes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');  // Drop the table if it exists
    }
}
