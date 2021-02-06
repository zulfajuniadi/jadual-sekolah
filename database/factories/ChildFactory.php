<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChildFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Child::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'points' => 0,
        ];
    }

    /**
     * Indicate that the guardian for a child
     *
     * @param  \App\Models\User  $guardian
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function guardian(User $guardian)
    {
        return $this->state(function (array $attributes) use ($guardian) {
            return [
                'user_id' => $guardian->getKey(),
            ];
        });
    }
}
