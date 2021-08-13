<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\User;
use App\Models\Auth\Role;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;
use App\Models\Auth\Permission;
use App\Sprint\Support\Traits\TogglesForeignKey;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use TogglesForeignKey;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this -> disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => UserTypeEnum::ADMIN(),
            'name' => config('sprint.access.role.super'),
        ]);

        // Non Grouped Permissions
        //

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => UserTypeEnum::ADMIN(),
            'name' => 'admin.access.user',
            'description' => 'All User Permissions',
        ]);

        $users -> children() -> saveMany([
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => UserTypeEnum::ADMIN(),
                'name' => 'admin.access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        // Assign Permissions to other Roles
        //

        $this -> enableForeignKeys();
    }
}
