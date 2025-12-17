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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('record_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable()->comment('Phone Number');
            $table->string('whatsapp_phone_number')->nullable()->comment('WhatsApp phone number');
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->date('become_investor_at')->nullable()->comment('Became a Customer Date (Fixed) ');
            $table->date('close_date')->nullable();
            $table->integer('days_to_close')->nullable();
            $table->boolean('is_unworked')->default(false)->comment('Contact unworked');
            $table->string('kyc_status')->nullable()->comment('nameScanKYCResult');
            $table->string('kyc_staus_em')->nullable();
            $table->string('kyc_staus_ex')->nullable();
            $table->string('entity')->nullable();
            $table->string('investor_type')->nullable()->comment('Type of Investor ');
            $table->string('membership_type')->nullable()->comment('Type of Membership (EM: New from Laravel)');
            $table->string('currency')->nullable();
            $table->string('contact_owner')->nullable()->comment('Contact Owner');
            $table->string('email_preference')->nullable()->comment('Email Preference');

            $table->string('ethis_eg')->nullable();
            $table->string('ethis_global')->nullable();
            $table->string('ethis_my_investor')->nullable()->comment('Ethis_MY Investor');
            $table->string('ethis_ae')->nullable();
            $table->string('ethis_id')->nullable();
            $table->string('ethis_my')->nullable();
            $table->string('ethis_x')->nullable();
            $table->string('gs')->nullable();
            $table->datetime('last_engaged_at')->nullable()->comment('Last Engagement Date');
            $table->datetime('last_activity')->nullable()->comment('Last Activity Date');
            $table->datetime('last_modified_at')->nullable()->comment('Last Modified Date');
            $table->string('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
