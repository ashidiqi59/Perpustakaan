<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'petugas_stok' role - no schema change needed since role is a varchar/string column.
     * This role is for staff managing book stock and collection (CRUD books).
     * It does NOT have scanner access (petugas) or user management access (admin).
     */
    public function up(): void
    {
        // The role column is already a string, so 'petugas_stok' is already a valid value.
        // This migration serves as documentation that 'petugas_stok' is now an official role.
        // No schema change required for string columns.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all petugas_stok users if needed (optional, commented out for safety)
        // DB::table('users')->where('role', 'petugas_stok')->delete();
    }
};
