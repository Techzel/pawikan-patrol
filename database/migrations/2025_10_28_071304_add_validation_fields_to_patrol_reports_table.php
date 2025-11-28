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
            // Add validation fields
            $table->string('validation_status')->nullable()->after('status');
            $table->text('validation_notes')->nullable()->after('validation_status');
            $table->foreignId('validated_by')->nullable()->after('validation_notes')->constrained('users')->onDelete('set null');
            $table->timestamp('validated_at')->nullable()->after('validated_by');
            $table->boolean('evidence_verified')->default(false)->after('validated_at');
            $table->boolean('location_verified')->default(false)->after('evidence_verified');
            $table->boolean('needs_followup')->default(false)->after('location_verified');
            $table->text('followup_notes')->nullable()->after('needs_followup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patrol_reports', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn([
                'validation_status',
                'validation_notes',
                'validated_by',
                'validated_at',
                'evidence_verified',
                'location_verified',
                'needs_followup',
                'followup_notes'
            ]);
        });
    }
};
