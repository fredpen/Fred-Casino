<?php

namespace Database\Seeders;

use App\Models\Casino;
use App\Models\CasinoListing;
use App\Models\Country;
use App\Models\User;
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
        User::factory(10)->create();
        Casino::factory(10)->create();
        Country::factory()
            ->has(CasinoListing::factory()->count(1), 'listings')
            ->count(5)
            ->create();
    }
}
