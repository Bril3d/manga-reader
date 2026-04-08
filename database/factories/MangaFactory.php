<?php

namespace Database\Factories;

use App\Models\Manga;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manga::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'author' => $this->faker->name(),
            'artist' => $this->faker->name(),
            'official_links' => $this->faker->url(),
            'track_links' => $this->faker->url(),
            'alternative_titles' => $this->faker->sentence(5),
            'cover' => 'https://picsum.photos/seed/' . Str::random(10) . '/300/450',
            'rate' => $this->faker->randomFloat(1, 1, 5),
            'user_id' => User::first()?->id ?? User::factory(),
            'releaseDate' => $this->faker->year(),
            'type' => $this->faker->randomElement(['Manga', 'Manhua', 'Manhwa']),
        ];
    }
}
