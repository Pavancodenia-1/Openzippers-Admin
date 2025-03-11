<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,  // Randomly select a user
            'title' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'type' => $this->faker->word,
            'type_id' => $this->faker->uuid,
            'status' => $this->faker->randomElement([0, 1]),
            'is_certified' => $this->faker->boolean ? 'yes' : 'no',
            'is_publish' => $this->faker->boolean ? 'yes' : 'no',
            'audio_image_url' => $this->faker->imageUrl(),
            'stream_audio_image' => $this->faker->imageUrl(),
            'video_image_url' => $this->faker->imageUrl(),
            'filename' => $this->faker->word,
            
        ];
    }
}
