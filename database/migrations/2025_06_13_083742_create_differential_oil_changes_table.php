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
        Schema::create('differential_oil_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained('maintenance_records')->onDelete('cascade');
            $table->string('oil_type');
            $table->float('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('differential_oil_changes');
    }
};
