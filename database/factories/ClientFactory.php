<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        return [
            'name'    => $faker->name,
            'bsn'     => $faker->numerify('#########'),
            'phone'   => $faker->phoneNumber,
            'address' => $faker->address,
            'gender'  => $faker->randomElement(['male', 'female']),
        ];
    }
}
