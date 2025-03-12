<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['jpg', 'png', 'pdf', 'mp3', 'mp4', 'wav'];

        return [
            'id' => Str::uuid(), // Generate a random UUID for the attachment
            'filename' => $this->faker->word() . '.jpg', // Fake filename
            'driver' => $this->faker->numberBetween(1, 3), // Random driver value (you can adjust based on your data)
            'type' => $this->faker->randomElement($types), // Ensure it picks from the allowed types
            'user_id' => User::inRandomOrder()->first()->id ?? null, // Random user ID from the User table, or null
            'post_id' => Post::inRandomOrder()->first()->id ?? null, // Random post ID from the Post table, or null
            'wfilename' => $this->faker->word() . '.jpg', // Fake wfilename
            'message_id' => $this->faker->numberBetween(1, 100), // Random message_id value
            'payment_request_id' => $this->faker->numberBetween(1, 100), // Random payment_request_id value
            'mtype' => $this->faker->numberBetween(1, 5), // Random mtype value
            'attachmentscol' => $this->faker->word(), // F
        ];
    }
}
