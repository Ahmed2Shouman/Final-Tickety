<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 10)->default('usd');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('method', 50)->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('stripe_receipt_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
