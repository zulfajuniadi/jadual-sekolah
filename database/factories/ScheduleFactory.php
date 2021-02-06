<?php

namespace Database\Factories;

use App\Models\Child;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $carbon = today()->setTime(
            $this->faker->time('H'), $this->faker->time('i')
        );

        return [
            'day' => $this->faker->numberBetween(1, 7),
            'start_time' => $carbon,
            'end_time' => $carbon->copy()->addMinutes(30),
        ];
    }

    /**
     * Indicate that the schedule for a student
     *
     * @param  \App\Models\Child  $student
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function student(Child $student)
    {
        return $this->state(function (array $attributes) use ($student) {
            return [
                'user_id' => $student->user_id,
                'child_id' => $student->getKey(),
            ];
        });
    }
}
