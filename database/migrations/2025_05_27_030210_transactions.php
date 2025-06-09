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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->nullable(); // Definisi kolom dan nullable
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade'); // Foreign key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('keterangan');
            $table->integer('status');
            $table->decimal('biaya', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
