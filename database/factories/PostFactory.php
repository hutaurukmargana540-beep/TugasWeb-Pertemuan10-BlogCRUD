<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'   => rtrim(fake()->sentence(rand(3, 7)), '.'),
            'content' => fake()->paragraphs(rand(2, 4), true),
            'image'   => null,
        ];
    }
}
