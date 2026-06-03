<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $services = [
            ['name' => 'Consultation Générale', 'price' => 50],
            ['name' => 'Bilan Complet', 'price' => 120],
            ['name' => 'Radiographie', 'price' => 75],
            ['name' => 'Analyse Sang', 'price' => 40],
            ['name' => 'Vaccination', 'price' => 30],
        ];

        $service = fake()->randomElement($services);

        return [
            'name' => $service['name'],
            'description' => fake()->sentence(10),
            'price' => $service['price'],
        ];
    }
}
