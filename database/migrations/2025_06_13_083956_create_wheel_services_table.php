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
        Schema::create('wheel_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('record_id')->constrained('maintenance_records')->onDelete('cascade');
            $table->string('wheel_name');
            $table->string('quantity');
            $table->string('wheel_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheel_services');
    }
};
