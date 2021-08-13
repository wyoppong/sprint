<?php

namespace Database\Seeders\Auth;

use App\Models\Auth\User;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;
use App\Sprint\Support\Traits\Helpers;
use App\Sprint\Support\Traits\TogglesForeignKey;

/**
 * Class UserTableSeeder.
 */
class UserSeeder extends Seeder
{
    use TogglesForeignKey, Helpers;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this -> disableForeignKeys();

        // Add the super administrator, user id of 1
        User::create([
            'type' => UserTypeEnum::ADMIN(),
            'name' => 'W i Z y',
            'username' => 'wiz@admin.com',
            'email' => 'wiz@admin.com',
            'password' => $this -> hashPassword('secret'),
            'email_verified_at' => now(),
            'active' => true,
        ]);

        if (app() -> environment(['local', 'testing'])) {
            User::create([
                'type' => UserTypeEnum::USER(),
                'name' => 'dikembe motumbo',
                'username' => 'dikembe',
                'email' => 'user@user.com',
                'password' => $this -> hashPassword('secret'),
                'email_verified_at' => now(),
                'active' => true,
            ]);
        }

        $this -> enableForeignKeys();
    }
}
