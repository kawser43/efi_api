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
        Schema::create('user_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('record_id_company')->nullable();
            $table->string('company_name')->nullable();
            $table->string('country_of_registration')->nullable();
            $table->string('registration_number')->nullable()->comment('Company Registration Number');
            $table->date('incorporation_date')->nullable()->comment('Incorporation Date');
            $table->string('incorporation_certificate')->nullable()->comment('Company Incorporation Certificate');
            $table->boolean('company_investor_declaration')->nullable()->comment('Declaration for Company Investors ');
            $table->string('business_type')->nullable();
            $table->string('designation')->nullable();
            $table->integer('number_of_directors')->nullable();
            $table->integer('number_of_shareholders')->nullable();
            $table->string('name_of_employer')->nullable()->comment('Name of employer or nature of self-employment / nature of business');
            $table->string('occupation')->nullable();
            $table->string('place_of_incorporation')->nullable();
            $table->string('company_domain')->nullable();
            $table->string('company_owner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_companies');
    }
};
