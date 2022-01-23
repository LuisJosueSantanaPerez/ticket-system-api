<?php

namespace Database\Seeders;

use App\Models\Employee;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('statuses')->insert([
            ['name' => 'Open'], ['name' => 'Process'], ['name' => 'Closed']
        ]);
        DB::table('categories')->insert([
            ['name' => 'Support'], ['name' => 'IT Department'],
            ['name' => 'Programmer'], ['name' => 'Marketing'],
            ['name'=> 'Data base']
        ]);
        DB::table('kinds')->insert([
            ['name' => 'Ticket'], ['name' => 'Bug'], ['name' => 'Suggestion'],
            ['name' => 'Feature']
        ]);

        DB::table('priorities')->insert([
            ['name' => 'High'], ['name' => 'Medium'], ['name' => 'low'],
        ]);

        Employee::create(
            [
                'first_name' => 'Admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin1234'),
                'email_verified_at' => now()
            ]
        );
        //\App\Models\Employee::factory(4)->create();
        // \App\Models\Category::factory(4)->create();
        // \App\Models\Kind::factory(4)->create();
        // \App\Models\Priority::factory(4)->create();
        // \App\Models\Status::factory(4)->create();
    }
}
