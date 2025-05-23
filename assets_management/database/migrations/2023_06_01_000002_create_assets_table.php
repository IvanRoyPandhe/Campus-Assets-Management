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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique(); // Unique asset code for QR generation
            $table->string('name');
            $table->string('category');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->enum('condition', ['good', 'damaged', 'under repair', 'disposed']);
            $table->text('description')->nullable();
            $table->date('purchase_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};