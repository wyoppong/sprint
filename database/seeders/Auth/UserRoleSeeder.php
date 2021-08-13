<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use App\Sprint\Support\Traits\TogglesForeignKey;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleSeeder extends Seeder
{
    use TogglesForeignKey;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this -> disableForeignKeys();

        User::find(1) -> assignRole(config('sprint.access.role.super'));

        $this -> enableForeignKeys();
    }
}
