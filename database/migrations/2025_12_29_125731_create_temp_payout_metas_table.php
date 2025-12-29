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
        Schema::create('temp_payout_metas', function (Blueprint $table) {
            $table->id();
            $table->integer('sequence');
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->string('sheet_name')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_payout_metas');
    }
};
