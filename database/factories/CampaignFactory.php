<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'list_id'          => \App\Models\EmailList::factory(),
            'name'             => $this->faker->name,
            'subject'          => $this->faker->sentence,
            'content'          => $this->faker->text,
            'scheduled_at'     => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'status'           => 0,
            'total_recipients' => 2 ,
            'delivered'        => 3,
            'opens'            => 2,
            'clicks'           => 2 ,
            'unsubscribes'     => 2 ,
            'bounces'          => 2 ,
            'complaints'       => 2 ,
            'from_name'        => $this->faker->name,
            'from_email'       => $this->faker->email,
            'type'             => $this->faker->name,
            'user_id'          => User::factory(),
        ];
    }
}
