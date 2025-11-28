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
        Schema::table('patrol_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('patrol_reports', 'gender')) {
                $table->string('gender')->nullable()->after('evidence');
            }

            if (!Schema::hasColumn('patrol_reports', 'egg_count')) {
                $table->unsignedInteger('egg_count')->nullable()->after('gender');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patrol_reports', function (Blueprint $table) {
            if (Schema::hasColumn('patrol_reports', 'egg_count')) {
                $table->dropColumn('egg_count');
            }

            if (Schema::hasColumn('patrol_reports', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};
