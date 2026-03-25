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
        Schema::create('oil_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained('maintenance_records')->onDelete('cascade');
            $table->string('current_km')->nullable();
            $table->string('oil_type')->nullable();
            $table->string('oil_quantity')->nullable();
            $table->string('filter')->nullable();
            $table->string('next_change_km')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_changes');
    }
};
