<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $exampleData = config('example-data');

        foreach ($exampleData['users'] as $user) {
            \App\Models\User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'since' => $user['since'],
                'revenue' => $user['revenue']
            ]);
        }
    }
}
