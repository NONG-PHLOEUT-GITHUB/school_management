<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create();

         \App\Models\User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'School',
            'email' => 'admin@gmail.com',
            'password' => 'admin1234',
        ]);
    }
}
