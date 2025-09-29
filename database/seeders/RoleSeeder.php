<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permission management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            
            // Course management (for OTT platform)
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            
            // Content management
            'view content',
            'create content',
            'edit content',
            'delete content',
            
            // System settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin role - full access
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Instructor role - content creation and management
        $instructorRole = Role::firstOrCreate(['name' => 'instructor']);
        $instructorRole->givePermissionTo([
            'view courses',
            'create courses',
            'edit courses',
            'view content',
            'create content',
            'edit content',
        ]);

        // Student/User role - basic access
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $userRole->givePermissionTo([
            'view courses',
            'view content',
        ]);

        // Moderator role - moderate content
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $moderatorRole->givePermissionTo([
            'view users',
            'view courses',
            'view content',
            'edit content',
        ]);

        $this->command->info('Roles and permissions created successfully!');
    }
}
