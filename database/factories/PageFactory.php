<?php

namespace Modules\Pages\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Jaymeh\FilamentPages\Models\Page::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
