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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('place');
            $table->longText('description');
            $table->longText('MaintenanceAssistant')->nullable(); // Modifier pour autoriser les valeurs NULL
            $table->longText('resolved')->nullable(); // Modifier pour autoriser les valeurs NULL
            $table->date('start_date')->default(now());
            $table->date('due_date')->nullable();
            $table->string('status')->default('nouveau');
            $table->foreignId('user_created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_assigned_to')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
