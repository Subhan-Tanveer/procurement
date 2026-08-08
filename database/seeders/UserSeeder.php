<?php

namespace Database\Seeders;

use App\Models\AssignedRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (updateOrCreate to avoid duplicate errors)
        User::updateOrCreate(
            ['email' => 'admin@goodprocurement.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone_number' => '+234 800 000 0000',
                'job_title' => 'System Owner',
                'department' => 'Executive',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $adminUser = User::updateOrCreate(
            ['email' => 'operations@goodprocurement.com'],
            [
                'name' => 'Operations Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone_number' => '+234 800 000 0001',
                'job_title' => 'Operations Lead',
                'department' => 'Operations',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $quotationUser = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Quotation Officer',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone_number' => '+234 800 000 0002',
                'job_title' => 'Quotation Officer',
                'department' => 'Procurement',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $quotationRole = AssignedRole::where('name', 'quotation_officer')->first();
        $contentRole = AssignedRole::where('name', 'content_editor')->first();

        if ($quotationRole) {
            $quotationUser->assignedRoles()->syncWithoutDetaching([$quotationRole->id]);
        }

        if ($contentRole) {
            $adminUser->assignedRoles()->syncWithoutDetaching([$contentRole->id]);
        }
    }
}
