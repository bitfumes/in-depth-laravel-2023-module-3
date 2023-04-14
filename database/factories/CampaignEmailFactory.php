<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CampaignEmail>
 */
class CampaignEmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject'         => $this->faker->sentence(),
            'content'         => $this->faker->paragraph(),
            'sent_at'         => $this->faker->dateTime(),
            'opened_at'       => $this->faker->dateTime(),
            'clicked_at'      => $this->faker->dateTime(),
            'unsubscribed_at' => $this->faker->dateTime(),
            'bounced_at'      => $this->faker->dateTime(),
            'complained_at'   => $this->faker->dateTime(),
        ];
    }
}
