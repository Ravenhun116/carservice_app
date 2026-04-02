<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->integer('log_number');
            $table->string('event');
            $table->timestamp('event_time')->nullable();
            $table->string('document_id');
            $table->unique(['car_id', 'log_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }

};
