<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Employee::factory(4)->create();
        \App\Models\Category::factory(4)->create();
        \App\Models\Kind::factory(4)->create();
        \App\Models\Priority::factory(4)->create();
        \App\Models\Status::factory(4)->create();
    }
}
