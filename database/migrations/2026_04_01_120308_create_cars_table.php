<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('type');
            $table->timestamp('registered');
            $table->boolean('ownbrand')->default(0);
            $table->integer('accident')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }

};
