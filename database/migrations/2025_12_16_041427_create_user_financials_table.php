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
        Schema::create('user_financials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->float('invest_amount_sgd')->nullable()->comment('Invest Amount (SGD)');
            $table->float('total_investment_amount')->nullable();
            $table->float('total_returned_amount')->nullable();
            $table->float('total_revenue')->nullable();
            $table->float('total_money_raised')->nullable();

            $table->float('open_deal_value')->nullable();
            $table->float('closed_deal_value')->nullable();
            $table->float('roi_percentage')->nullable();
            $table->date('last_invested_at')->nullable()->comment('Last Investment Date');
            $table->float('recent_deal_amount')->nullable()->comment('Recent deal');
            $table->dateTime('recent_deal_date')->nullable()->comment('Recent deal');
            $table->integer('investment_through_em')->nullable()->comment('Invested through Ethis Malaysia');
            $table->integer('number_of_investment_em')->nullable()->comment('Number of Investments in EM');
            $table->integer('number_of_investment_ex')->nullable()->comment('Number of Investments in EX');
            $table->integer('number_of_investment_ei_global')->nullable()->comment('Number of investments EI Global');

            $table->float('total_invested_through_ei_global_sgd')->nullable()->comment('Total Invested through EI Global (SGD)');
            $table->float('total_amount_reinvested_through_ei_global_sgd')->nullable()->comment('Total Amount Reinvested through EI Global (SGD)');
            $table->float('total_new_amount_reinvested_through_ei_global_sgd')->nullable()->comment('Total New amount invested through EI Global (SGD)');

            $table->float('total_invested_through_em_myr')->nullable();
            $table->float('total_invested_through_ex_usd')->nullable();

            $table->float('total_investment_in_delayed_projects')->nullable();
            $table->float('total_payout_for_ethis_fund_idr')->nullable();
            $table->float('total_payout_for_ethis_fund_usd')->nullable();

            $table->float('annual_revenue')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_financials');
    }
};
