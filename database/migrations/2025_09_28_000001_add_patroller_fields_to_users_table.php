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
        Schema::table('users', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }
            
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('is_active');
            }
            
            if (!Schema::hasColumn('users', 'patroller_id')) {
                $table->string('patroller_id')->unique()->nullable()->after('last_login_at');
            }
            
            if (!Schema::hasColumn('users', 'badge_number')) {
                $table->string('badge_number')->nullable()->after('patroller_id');
            }
            
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('badge_number');
            }
            
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('bio');
            }
            
            if (!Schema::hasColumn('users', 'patrol_areas')) {
                $table->json('patrol_areas')->nullable()->after('profile_picture');
            }
            
            if (!Schema::hasColumn('users', 'total_patrols')) {
                $table->integer('total_patrols')->default(0)->after('patrol_areas');
            }
            
            if (!Schema::hasColumn('users', 'turtles_saved')) {
                $table->integer('turtles_saved')->default(0)->after('total_patrols');
            }
            
            if (!Schema::hasColumn('users', 'nests_protected')) {
                $table->integer('nests_protected')->default(0)->after('turtles_saved');
            }
            
            if (!Schema::hasColumn('users', 'patroller_since')) {
                $table->timestamp('patroller_since')->nullable()->after('nests_protected');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'phone', 
                'role',
                'is_active',
                'last_login_at',
                'patroller_id',
                'badge_number',
                'bio',
                'profile_picture',
                'patrol_areas',
                'total_patrols',
                'turtles_saved',
                'nests_protected',
                'patroller_since'
            ]);
        });
    }
};
