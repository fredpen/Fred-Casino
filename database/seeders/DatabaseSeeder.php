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
        Casino::factory(20)->create();
        Country::factory(20)->create();
        CasinoListing::factory(3)->create();

    }
}
