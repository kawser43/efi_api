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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('project_name')->nullable();
            $table->integer('number_of_transactions')->nullable();
            $table->float('crowdfunded_amount_sgd')->nullable();
            $table->float('crowdfunded_amount_idr')->nullable();
            $table->date('project_commencement')->nullable();
            $table->float('projected_roi_percentage')->nullable();
            $table->float('actual_roi_percentage')->nullable();

            $table->date('due_date')->nullable();
            $table->date('payout_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->float('payout_status_percentage')->nullable();
            $table->string('project_status')->nullable();
            $table->float('actual_payout_idr')->nullable();
            $table->float('agency_fee_idr')->nullable();
            $table->float('tax_idr')->nullable();
            $table->float('withdrawn_idr')->nullable();
            $table->float('reinvested_idr')->nullable();
            $table->float('available_idr')->nullable();
            $table->string('payout_process')->nullable();
            $table->date('payment_date')->nullable()->comment('Payment Date By issuer');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
