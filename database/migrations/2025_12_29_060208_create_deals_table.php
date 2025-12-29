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
            $table->unsignedBigInteger('user_id')->comment('Mapped from Associated Contact IDs');

            // Deal Identifiers
            $table->bigInteger('deal_record_id')->nullable()->comment('Record ID from Deals sheet');
            $table->string('deal_name')->nullable();
            $table->string('pipeline')->nullable();
            $table->string('deal_stage')->nullable();

            // Financial Data
            $table->decimal('amount_sgd', 18, 4)->nullable();
            $table->decimal('amount_idr', 18, 4)->nullable();
            $table->decimal('profit_idr', 18, 4)->nullable();
            $table->decimal('weighted_amount', 18, 4)->nullable();
            $table->decimal('weighted_amount_company_currency', 18, 4)->nullable();

            // Metadata & Classification
            $table->string('transaction_type')->default('incoming')->comment('incoming (fund) or outgoing (payout)');
            $table->string('investor_name_at_transaction')->nullable()->comment('Name of the Investor from deals sheet');
            // $table->string('investor_nationality_at_transaction')->nullable()->comment('Nationality from deals sheet');

            // Dates
            $table->dateTime('deal_close_at')->nullable()->comment('Close Date');
            $table->dateTime('deal_created_at')->nullable()->comment('Create Date');

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
