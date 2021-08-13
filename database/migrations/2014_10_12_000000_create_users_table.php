<?php

use App\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint ;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table -> id();
            $table -> enum('type', [UserTypeEnum::ADMIN(), UserTypeEnum::USER()]) -> default(UserTypeEnum::USER());
            $table -> string('name');
            $table -> string('username');
            $table -> string('email') -> unique();
            $table -> timestamp('email_verified_at') -> nullable();
            $table -> string('password');
            $table -> boolean('active') -> default(true);
            $table -> string('timezone') -> nullable();
            $table -> timestamp('last_login_at') -> nullable();
            $table -> string('last_login_ip') -> nullable();
            $table -> boolean('to_be_logged_out') -> default(false);
            $table -> text('profile_photo_path') -> nullable();
            $table -> rememberToken();
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
