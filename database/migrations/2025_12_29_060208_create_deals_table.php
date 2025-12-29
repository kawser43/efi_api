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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            // Relationship to the users table
            $table->unsignedBigInteger('user_id')->comment('Mapped from Associated Contact IDs')->nullable();
            $table->unsignedBigInteger('associated_contact_id')->nullable()->comment('record id in users table');

            // Deal Identifiers
            $table->bigInteger('deal_record_id')->nullable()->comment('Record ID from Deals sheet');
            $table->string('deal_name')->nullable();
            $table->string('pipeline')->nullable();
            $table->string('deal_stage')->nullable();

            // Financial Data
            $table->float('amount_sgd')->nullable();
            $table->float('amount_idr')->nullable();
            $table->float('profit_idr')->nullable();
            $table->float('weighted_amount')->nullable();
            $table->float('weighted_amount_company_currency')->nullable();

            // Metadata & Classification
            $table->string('transaction_type')->default('incoming')->comment('incoming (fund) or outgoing (payout)');
            $table->string('investor_name_at_transaction')->nullable()->comment('Name of the Investor from deals sheet');
            // $table->string('investor_nationality_at_transaction')->nullable()->comment('Nationality from deals sheet');
            $table->tinyText('associated_contact')->nullable();

            // Dates
            $table->string('deal_close_at')->nullable()->comment('Close Date');
            $table->string('deal_created_at')->nullable()->comment('Create Date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
