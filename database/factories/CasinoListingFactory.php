<?php

namespace Database\Factories;

use App\Models\Casino;
use App\Models\CasinoListing;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CasinoListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' =>  Country::inRandomOrder()->first(),
            "casino_id" => Casino::inRandomOrder()->first(),
            'level' =>  $this->faker->numberBetween(1, 10000)
        ];
    }
}
