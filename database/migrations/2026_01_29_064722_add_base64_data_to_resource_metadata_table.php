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
        Schema::table('resource_metadata', function (Blueprint $table) {
            // Using longText to store PDF base64 data (Vercel/ephemeral storage fix)
            $table->longText('base64_data')->nullable()->after('filename');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_metadata', function (Blueprint $table) {
            $table->dropColumn('base64_data');
        });
    }
};
