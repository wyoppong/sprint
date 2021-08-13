<?php

namespace App\Sprint\Support\Traits;

use Illuminate\Support\Facades\Hash;

trait Helpers
{
    /**
     * @param $password
     */
    public function hashPassword($password): string
    {
        return (strlen($password) === 60 && preg_match('/^\$2y\$/', $password)) ||
               (strlen($password) === 95 && preg_match('/^\$argon2i\$/', $password)) ?
               $password :Hash::make($password);
    }

    /**
     * @param $password
     */
    public function checkHashedPassword($password)
    {
        return Hash::check($password);
    }

}
