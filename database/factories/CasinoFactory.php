<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CasinoFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            "logo_url" => $this->faker->imageUrl,
            'bonus_information' =>  $this->faker->paragraph(3),
            'affiliate_link' =>  $this->faker->url
        ];
    }
}
