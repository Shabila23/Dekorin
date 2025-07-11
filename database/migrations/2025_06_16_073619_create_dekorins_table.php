<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('dekorins', function (Blueprint $table) {
    $table->id();
    $table->string('tema');
    $table->unsignedBigInteger('category_id');
    $table->string('image')->nullable();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->float('rating')->nullable();
    $table->string('file')->nullable();
    $table->timestamps();

    $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('dekorins');
    }
};
