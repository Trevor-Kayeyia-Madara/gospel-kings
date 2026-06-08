<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage_events' => 'Manage Events',
            'manage_vip_packages' => 'Manage VIP Packages',
            'manage_guest_ministers' => 'Manage Guest Ministers',
            'manage_sponsors' => 'Manage Sponsors',
            'manage_announcements' => 'Manage Announcements',
            'manage_galleries' => 'Manage Galleries',
            'manage_media' => 'Manage Media',
            'manage_volunteers' => 'Manage Volunteers',
            'manage_donors' => 'Manage Donors',
            'manage_check_in' => 'Manage Check-In',
            'view_reports' => 'View Reports',
            'manage_finance' => 'Manage Finance',
        ];

        $permissionIds = [];
        foreach ($permissions as $name => $label) {
            $permission = Permission::updateOrCreate(['name' => $name], ['label' => $label]);
            $permissionIds[$name] = $permission->id;
        }

        $superAdmin = Role::updateOrCreate(['name' => 'super-admin'], ['label' => 'Super Administrator']);
        $ministryAdmin = Role::updateOrCreate(['name' => 'ministry-admin'], ['label' => 'Ministry Administrator']);
        $eventManager = Role::updateOrCreate(['name' => 'event-manager'], ['label' => 'Event Manager']);
        $financeOfficer = Role::updateOrCreate(['name' => 'finance-officer'], ['label' => 'Finance Officer']);
        $checkInOfficer = Role::updateOrCreate(['name' => 'check-in-officer'], ['label' => 'Check-In Officer']);

        $superAdmin->permissions()->sync(Permission::all());
        $ministryAdmin->permissions()->sync(Permission::all());
        $eventManager->permissions()->sync(Permission::whereIn('name', [
            'manage_events', 'manage_guest_ministers', 'manage_check_in', 'view_reports'
        ])->get());
        $financeOfficer->permissions()->sync(Permission::whereIn('name', [
            'manage_finance', 'view_reports', 'manage_donors'
        ])->get());
        $checkInOfficer->permissions()->sync(Permission::whereIn('name', [
            'manage_check_in', 'view_reports'
        ])->get());

        $admin = User::updateOrCreate(
            ['email' => 'admin@gospelkings.co.ke'],
            ['name' => 'Invodtech Admin', 'password' => bcrypt('password')]
        );
        $admin->roles()->sync([$superAdmin->id]);
    }
}
