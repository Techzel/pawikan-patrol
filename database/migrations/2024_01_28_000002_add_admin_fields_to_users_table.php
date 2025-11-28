<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('id'); // user, patroller, admin
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role'); // active, inactive
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'area_assignment')) {
                $table->string('area_assignment')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable()->after('updated_at');
            }
            
            // Add indexes for better performance (only if they don't exist)
            if (!Schema::hasIndex('users', 'role')) {
                $table->index('role');
            }
            
            if (!Schema::hasIndex('users', 'status')) {
                $table->index('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            $columnsToDrop = [];
            
            if (Schema::hasColumn('users', 'role')) {
                $columnsToDrop[] = 'role';
            }
            
            if (Schema::hasColumn('users', 'status')) {
                $columnsToDrop[] = 'status';
            }
            
            if (Schema::hasColumn('users', 'phone')) {
                $columnsToDrop[] = 'phone';
            }
            
            if (Schema::hasColumn('users', 'area_assignment')) {
                $columnsToDrop[] = 'area_assignment';
            }
            
            if (Schema::hasColumn('users', 'last_login_at')) {
                $columnsToDrop[] = 'last_login_at';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
