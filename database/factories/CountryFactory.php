<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->country,
            'iso2' => $this->faker->countryCode,
            'iso3' => $this->faker->countryISOAlpha3,
        ];
    }

    public function austria(): CountryFactory
    {
        return $this->state([
            'name' => 'Austria',
            'iso2' => 'AT',
            'iso3' => 'AUT',
        ]);
    }
}
