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
        Schema::create('user_company_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_company_id');
            $table->string('name')->nullable()->comment('First Director Name, Second Director Name, Third Director Name, Shareholder Name');
            $table->string('role')->nullable()->comment('Director | Shareholder');
            $table->string('position')->nullable();
            $table->string('share_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_company_people');
    }
};
