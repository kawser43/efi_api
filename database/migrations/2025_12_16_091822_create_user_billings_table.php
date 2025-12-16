<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_billings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('billing_address')->nullable()->comment('Billing Address Line 1');
            $table->string('billing_city')->nullable()->comment('Billing City');
            $table->string('billing_city')->nullable()->comment('Billing City');
            $table->string('billing_country')->nullable()->comment('Billing Country');
            $table->string('billing_state')->nullable()->comment('Billing State');
            $table->string('account_country')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_type')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('bank_branch')->nullable()->comment('Branch');
            $table->boolean('has_no_change')->nullable()->comment('No change in bank details');
            $table->string('payout_currency')->nullable()->comment('Preferred Currency for Payout');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_billings');
    }
};
