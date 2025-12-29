<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payout_id');
            $table->float('capital')->nullable();
            $table->float('tax')->nullable();
            $table->float('partial')->nullable();
            $table->float('profit')->nullable();
            $table->float('available_amount_after_tax')->nullable();
            $table->float('payout_actual')->nullable();
            $table->string('currency')->default('idr');

            $table->float('payout_actual_transfer')->nullable();
            $table->string('transfer_currency')->nullable();
            $table->float('exchange_rate')->nullable();
            $table->string('payout_status')->nullable();
            $table->string('purpose')->nullable();
            $table->date('payout_date')->nullable();
            $table->string('platform')->nullable();
            $table->string('investment_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
