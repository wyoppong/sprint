<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Sprint\Support\Traits\TruncatesTable;

class DatabaseSeeder extends Seeder
{
    use TruncatesTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Auth\User::factory(5) -> create();

        Model::unguard();

        // $this->truncateMultiple([
        //     'activity_log',
        //     'failed_jobs',
        // ]);

        $this -> call(AuthSeeder::class);

        Model::reguard();
    }
}
