<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name'    => fake()->name(),
            'bsn'     => fake()->numerify('#########'),
            'phone'   => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gender'  => fake()->randomElement(['male', 'female']),

        ];
    }
}
