<?php

namespace Database\Seeders;

use App\Models\Manga;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MangaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Genres
        $genres = [
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy',
            'Horror', 'Mystery', 'Psychological', 'Romance', 'Sci-Fi',
            'Slice of Life', 'Supernatural', 'Thriller', 'Ecchi', 'Isekai'
        ];

        $genreIds = [];
        foreach ($genres as $genre) {
            $taxonomy = Taxonomy::updateOrCreate(
                ['slug' => Str::slug($genre), 'type' => 'genre'],
                ['title' => $genre, 'description' => "$genre genre"]
            );
            $genreIds[] = $taxonomy->id;
        }

        // 2. Get existing Types and Statuses
        $typeIds = Taxonomy::where('type', 'manga_type')->pluck('id')->toArray();
        $statusIds = Taxonomy::where('type', 'manga_status')->pluck('id')->toArray();

        // 3. Get the admin user
        $user = User::where('username', 'admin')->first() ?? User::first();

        if (!$user) {
            $this->command->error('No user found to associate mangas with. Please run DatabaseSeeder first.');
            return;
        }

        // 4. Create Mangas
        Manga::factory()->count(20)->create([
            'user_id' => $user->id
        ])->each(function ($manga) use ($genreIds, $typeIds, $statusIds) {
            // Attach 2-4 random genres
            $randomGenres = array_rand(array_flip($genreIds), rand(2, 4));
            $manga->genres()->attach($randomGenres);

            // Attach 1 random type
            if (!empty($typeIds)) {
                $randomType = array_rand(array_flip($typeIds));
                $manga->types()->attach($randomType);
            }

            // Attach 1 random status
            if (!empty($statusIds)) {
                $randomStatus = array_rand(array_flip($statusIds));
                $manga->status()->attach($randomStatus);
            }
        });
    }
}
