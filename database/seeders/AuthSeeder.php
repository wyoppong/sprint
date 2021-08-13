<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Auth\UserSeeder;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\Auth\UserRoleSeeder;
use Spatie\Permission\PermissionRegistrar;
use App\Sprint\Support\Traits\TruncatesTable;
use Database\Seeders\Auth\PermissionRoleSeeder;
use App\Sprint\Support\Traits\TogglesForeignKey;

/**
 * Class AuthTableSeeder.
 */
class AuthSeeder extends Seeder
{
    use TogglesForeignKey, TruncatesTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this -> disableForeignKeys();

        // Reset cached roles and permissions
        // Artisan::call('cache:clear');
        // resolve(PermissionRegistrar::class)->forgetCachedPermissions();

        // $this->truncateMultiple([
        //     config('permission.table_names.model_has_permissions'),
        //     config('permission.table_names.model_has_roles'),
        //     config('permission.table_names.role_has_permissions'),
        //     config('permission.table_names.permissions'),
        //     config('permission.table_names.roles'),
        //     'users',
        //     'password_histories',
        //     'password_resets',
        // ]);

        $this -> call(UserSeeder::class);
        $this -> call(PermissionRoleSeeder::class);
        $this -> call(UserRoleSeeder::class);

        $this -> enableForeignKeys();
    }
}
