<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create CEO user (Dandy - highest access)
        \App\Models\User::create([
            'name' => 'Dandy CEO',
            'email' => 'dandy@secondcycle.id',
            'password' => \Hash::make('ceo123'),
            'role' => 'ceo',
            'email_verified_at' => now(),
        ]);

        // Create Admin user (full admin access)
        \App\Models\User::create([
            'name' => 'Admin SecondCycle',
            'email' => 'admin@secondcycle.id',
            'password' => \Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Manager user (limited admin access)
        \App\Models\User::create([
            'name' => 'Manager SecondCycle',
            'email' => 'manager@secondcycle.id',
            'password' => \Hash::make('manager123'),
            'role' => 'manager',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Role hierarchy users created successfully!');
        $this->command->info('');
        $this->command->info('👑 CEO (Dandy - Highest Access):');
        $this->command->info('   📧 Email: dandy@secondcycle.id');
        $this->command->info('   🔑 Password: ceo123');
        $this->command->info('   📋 Access: Full system control, user management, all features');
        $this->command->info('');
        $this->command->info('🔧 Administrator (Full Admin Access):');
        $this->command->info('   📧 Email: admin@secondcycle.id');
        $this->command->info('   🔑 Password: admin123');
        $this->command->info('   📋 Access: User management, products, contacts, dashboard');
        $this->command->info('');
        $this->command->info('📊 Manager (Limited Admin Access):');
        $this->command->info('   📧 Email: manager@secondcycle.id');
        $this->command->info('   🔑 Password: manager123');
        $this->command->info('   📋 Access: Products, contacts, dashboard (no user management)');
        $this->command->info('');
        $this->command->info('⚠️  Please change default passwords after first login!');
    }
}
