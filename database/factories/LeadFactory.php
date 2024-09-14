<?php

namespace Database\Factories;

use App\Domain\Models\Lead;
use App\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'source' => $this->faker->randomElement(['Fotocasa', 'Fotopuerta', 'Fotoventana']),
            'owner' => User::factory(),
            'created_by' => User::factory(),
            'created_at' => now(),
        ];
    }
}
