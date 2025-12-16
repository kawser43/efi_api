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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('city')->nullable();
            $table->string('city_2')->nullable();
            $table->string('state')->nullable()->comment('State/Region');
            $table->string('country')->nullable()->comment('Country/Region');
            $table->string('country_2')->nullable()->comment('Country/Region');
            $table->string('nationality')->nullable();
            $table->string('registration_country')->nullable()->comment('Country of Registration');
            $table->string('passport_country')->nullable()->comment('Country of Passport (For KYC Aug 21)');
            $table->string('passport_country_no_us_israel')->nullable()->comment('Country of Passport - Less US/Israel');
            $table->string('residence_country')->nullable()->comment('Country of Residence');
            $table->string('residence_country_new')->nullable()->comment('Country of Residence - (New: Dropdown list)');
            $table->string('residence_country_no_israel')->nullable()->comment('Country of Residence - Less Israel');
            $table->string('residence_country_no_us_israel')->nullable()->comment('Country of Residence - Less US/Israel');
            $table->string('occupation')->nullable()->comment('Occupation');
            $table->text('street_address')->nullable();
            $table->text('street_address_1')->nullable();
            $table->text('street_address_2')->nullable();
            $table->text('home_address')->nullable()->comment('Home Address');
            $table->text('address_line')->nullable()->comment('Address Line');
            $table->text('bank_address')->nullable()->comment('Bank Address');
            $table->string('postal_code')->nullable()->comment('Postal Code');
            $table->text('address_verification_proof')->nullable()->comment('Address Verification Proof');

            $table->string('about_you')->nullable()->comment('About you');
            $table->date('customer_date')->nullable()->comment('Customer Date');
            $table->string('swap_investment_to')->nullable()->comment('I want to swap my investment from CSI to');
            $table->string('new_email')->nullable()->comment('New email');
            $table->boolean('t_and_c')->nullable()->comment('T&C');

            $table->string('passport_country')->nullable()->comment('Country of Passport (for KYC: New Aug 21)');
            $table->string('passport_country_no_us_israel')->nullable()->comment('Country of Passport - Less US/Israel');
            $table->string('passport_number')->nullable()->comment('Passport Number');
            $table->date('passport_expiry_date')->nullable()->comment('Passport Expiry Date');

            $table->boolean('is_kyc_submitted_by_investor')->nullable()->comment('KYC Form Submitted by Investor');
            $table->string('namescan_id')->nullable();
            $table->dateTime('kyc_submitted_at')->nullable()->comment('KYC Submission Date');
            $table->dateTime('kyc_verified_at')->nullable()->comment('KYC Verified Date');
            $table->dateTime('kyc_checked_at')->nullable()->comment('KYC Check (Date)');
            $table->string('rejection_reason')->nullable()->comment('KYC Rejection Reason');
            $table->string('id_passport_proof')->nullable()->comment('ID passport (File)');
            $table->string('industry')->nullable();
            $table->string('job_title')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
