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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('scan_date');       // Tanggal kehadiran (untuk cek 1x per hari)
            $table->timestamp('scanned_at'); // Waktu exact scan
            $table->string('notes')->nullable(); // Catatan opsional
            $table->timestamps();

            // Constraint: 1 user hanya bisa absen 1x per hari
            $table->unique(['user_id', 'scan_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
