<?php

namespace Database\Factories;

use App\Models\Children;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildrenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Children::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'point' => 0,
        ];
    }
}
