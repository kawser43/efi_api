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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('deal_id')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->tinyInteger('reinvestment_status')->default(0);
            $table->date('transaction_date')->nullable();
            $table->float('invested_amount_sgd')->nullable()->comment('Capital Invested sgd');
            $table->float('invested_amount_idr')->nullable()->comment('Capital Invested idr');
            $table->float('roi_percentage')->nullable()->comment('ROI sgd');
            $table->float('profit_margin_idr')->nullable()->comment('ROI idr');
            $table->float('estimated_tax_idr')->nullable()->comment('');
            $table->float('profit_margin_after_tax_idr')->nullable()->comment('');
            $table->float('agency_fee_percentage')->nullable()->comment('');
            $table->float('agency_fee_idr')->nullable()->comment('');
            $table->float('estimated_payout_before_tax_idr')->nullable()->comment('');
            $table->float('estimated_payout_after_tax_idr')->nullable()->comment('');
            $table->float('estimated_payout_after_tax_and_agency_fee_idr')->nullable()->comment('');
            $table->float('remaining_capital_idr')->nullable()->comment('');
            $table->float('remaining_profit_after_tax_idr')->nullable()->comment('');
            $table->float('total_return_after_tax_idr')->nullable()->comment('');
            $table->float('actual_roi_after_tax_percentage')->nullable()->comment('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
