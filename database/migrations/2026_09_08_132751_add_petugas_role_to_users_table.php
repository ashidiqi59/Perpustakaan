<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds 'petugas' role - no schema change needed since role is a varchar/string column.
     * We just document the new allowed value here.
     */
    public function up(): void
    {
        // The role column is already a string, so 'petugas' is already a valid value.
        // This migration serves as documentation that 'petugas' is now an official role.
        // No schema change required for string columns.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all petugas users if needed (optional, commented out for safety)
        // DB::table('users')->where('role', 'petugas')->delete();
    }
};
