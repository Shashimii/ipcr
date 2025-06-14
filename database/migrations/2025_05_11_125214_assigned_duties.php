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
        Schema::create('assigned_duties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('duty_id')->constrained('duties')->onDelete('cascade');
            $table->string('odts_code');
            $table->date('assigned_at');
            $table->boolean('is_done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_duties');
    }
};
