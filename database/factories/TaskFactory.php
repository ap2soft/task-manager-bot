<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Lottery;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taskDate = Carbon::parse(fake()->dateTimeBetween(startDate: '-1 week', endDate: '+1 week'));
        $notificationDate = Lottery::odds(3, 4)
            ->winner(fn() => $taskDate)
            ->loser(fn() => $taskDate->copy()->subHours(fake()->randomNumber(1)))
            ->choose();

        return [
            'user_id' => User::factory(),
            'title' => fake()->realText(45),
            'text' => fake()->realText(),
            'date' => $taskDate,
            'notify_at' => $notificationDate,
        ];
    }
}
