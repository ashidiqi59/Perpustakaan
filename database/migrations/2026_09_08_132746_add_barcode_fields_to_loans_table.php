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
        Schema::table('loans', function (Blueprint $table) {
            // Change status enum to support new statuses
            $table->enum('status', [
                'menunggu_konfirmasi',
                'peminjaman',
                'menunggu_pengembalian',
                'dikembalikan',
                'terlambat',
                'expired',
            ])->default('menunggu_konfirmasi')->change();

            // Loan barcode fields (shown to user to show to petugas)
            $table->string('loan_barcode', 64)->nullable()->unique()->after('notes');
            $table->timestamp('loan_barcode_expires_at')->nullable()->after('loan_barcode');
            $table->timestamp('loan_barcode_scanned_at')->nullable()->after('loan_barcode_expires_at');

            // Return barcode fields
            $table->string('return_barcode', 64)->nullable()->unique()->after('loan_barcode_scanned_at');
            $table->timestamp('return_barcode_expires_at')->nullable()->after('return_barcode');
            $table->timestamp('return_barcode_scanned_at')->nullable()->after('return_barcode_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn([
                'loan_barcode',
                'loan_barcode_expires_at',
                'loan_barcode_scanned_at',
                'return_barcode',
                'return_barcode_expires_at',
                'return_barcode_scanned_at',
            ]);

            $table->enum('status', ['peminjaman', 'dikembalikan', 'terlambat'])
                ->default('peminjaman')
                ->change();
        });
    }
};
