<?php

namespace Database\Factories;

use App\Models\Stuff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StuffFactory extends Factory
{
    protected $model = Stuff::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->word(),
            'type' => $this->faker->randomElement([Stuff::HTL_KLN, Stuff::LAB, Stuff::SARPRAS])
    	];
    }
}
