<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            }
            if (!Schema::hasColumn('users', 'verification_rejection_reason')) {
                $table->text('verification_rejection_reason')->nullable();
            }
            if (!Schema::hasColumn('users', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'verified_at')) {
                $table->timestamp('verified_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'verification_rejection_reason',
                'verified_by',
                'verified_at'
            ]);
        });
    }
};
