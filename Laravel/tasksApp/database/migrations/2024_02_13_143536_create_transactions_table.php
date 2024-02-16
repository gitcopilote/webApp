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
            $table->string('maintainerName')->nullable();
            $table->string('product');
            $table->integer('quantity')->nullable()->default(0);
            $table->string('action')->nullable();
            $table->integer('quantityRemaining')->nullable()->default(0);
            $table->integer('quantityOutgoing')->nullable()->default(0);
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
