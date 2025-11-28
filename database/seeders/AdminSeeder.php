<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default DENR admin account
        $admin = User::create([
            'name' => 'DENR Administrator',
            'username' => 'denr_admin',
            'email' => 'admin@denr.gov.ph',
            'password' => Hash::make('DenrAdmin2024!'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+63-2-928-XXXX',
            'area_assignment' => 'National',
        ]);

        $this->command->info('Default DENR Admin account created:');
        $this->command->info('Username: denr_admin');
        $this->command->info('Email: admin@denr.gov.ph');
        $this->command->info('Password: DenrAdmin2024!');
        $this->command->info('Please change the password after first login.');
    }
}
