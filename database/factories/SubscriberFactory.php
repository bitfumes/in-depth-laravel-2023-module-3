<?php

namespace Database\Factories;

use App\Models\EmailList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'list_id'         => EmailList::factory(),
            'email'           => $this->faker->email,
            'name'            => $this->faker->name,
            'status'          => $this->faker->boolean,
            'meta'            => [],
            'confirmed_at'    => $this->faker->dateTime,
            'unsubscribed_at' => $this->faker->dateTime,
        ];
    }
}
