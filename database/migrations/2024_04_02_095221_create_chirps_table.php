<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Define a new anonymous class that extends the Migration class
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the 'chirps' table
        Schema::create('chirps', function (Blueprint $table) {
            $table->id(); // Create an auto-incrementing primary key column
            // Define a foreign key column referencing the 'id' column of the 'users' table
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('message'); // Define a column to store the chirp message
            $table->timestamps(); // Create 'created_at' and 'updated_at' columns for timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'chirps' table if it exists
        Schema::dropIfExists('chirps');
    }
}; 
