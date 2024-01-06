<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ApiSource;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        ApiSource::factory()->create([
            'name' => 'NewsApi'
        ]);

        ApiSource::factory()->create([
            'name' => 'Guardian'
        ]);

        ApiSource::factory()->create([
            'name' => 'NYT'
        ]);

        Category::factory()->create([
            'id' => 1,
            'name' => 'general'
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
