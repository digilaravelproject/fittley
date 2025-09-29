<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'view dashboard',
            'manage courses',
            'view courses',
            'create courses',
            'edit courses',
            'delete courses',
            'manage content',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $instructorRole = Role::create(['name' => 'instructor']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $instructorRole->givePermissionTo([
            'view dashboard',
            'manage courses',
            'view courses',
            'create courses',
            'edit courses',
            'manage content',
            'view reports',
        ]);

        $userRole->givePermissionTo([
            'view courses',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@fitlley.com',
            'phone' => '+1234567890',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        // Create instructor user
        $instructor = User::create([
            'name' => 'Instructor User',
            'email' => 'instructor@fitlley.com',
            'phone' => '+1234567891',
            'password' => Hash::make('instructor123'),
            'email_verified_at' => now(),
        ]);

        $instructor->assignRole('instructor');

        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@fitlley.com',
            'phone' => '+1234567892',
            'password' => Hash::make('user123'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('user');

        // Create additional test user for Firebase OTP testing
        $testUser = User::create([
            'name' => 'Test User OTP',
            'email' => 'test@fitlley.com',
            'phone' => '+1234567893',
            'password' => Hash::make('test123'),
            'email_verified_at' => now(),
        ]);

        $testUser->assignRole('user');

        $this->command->info('Admin seeder completed successfully!');
        $this->command->info('Admin credentials: admin@fitlley.com / admin123 / +1234567890');
        $this->command->info('Instructor credentials: instructor@fitlley.com / instructor123 / +1234567891');
        $this->command->info('User credentials: user@fitlley.com / user123 / +1234567892');
        $this->command->info('Test OTP credentials: test@fitlley.com / test123 / +1234567893');
    }
}
