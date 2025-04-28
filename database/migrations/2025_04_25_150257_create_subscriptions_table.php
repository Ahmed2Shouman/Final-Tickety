<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');  // Foreign key to the company
            $table->string('plan_type');               // Type of subscription (e.g., 'Basic', 'Premium')
            $table->date('subscription_start');        // Subscription start date
            $table->date('subscription_end');          // Subscription end date
            $table->enum('payment_status', ['paid', 'pending']); // Payment status
            $table->integer('cinema_count');           // Number of cinemas covered by the plan
            $table->boolean('active')->default(true);  // If the subscription is still active
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
