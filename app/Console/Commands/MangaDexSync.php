<?php

namespace App\Console\Commands;

use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Taxonomy;
use App\Models\Taxable;
use App\Services\MangaDexService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class MangaDexSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mangadex:sync {manga_id? : The MangaDex UUID to sync} {--chapters=5 : Number of chapters to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync manga data and images from MangaDex';

    protected $service;

    public function __construct(MangaDexService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mangaId = $this->argument('manga_id');

        if (!$mangaId) {
            $this->info('No input provided, fetching a random manga...');
            $randomManga = $this->service->getRandomManga();
            if (!$randomManga) {
                $this->error('Failed to fetch a random manga.');
                return 1;
            }
            $mangaId = $randomManga['id'];
        } elseif (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $mangaId)) {
            $this->info("Searching for manga with title: {$mangaId}...");
            $searchResults = $this->service->searchManga($mangaId);
            if (empty($searchResults)) {
                $this->error('No manga found with that title.');
                return 1;
            }
            $mangaId = $searchResults[0]['id'];
        }

        $this->info("Fetching data for Manga: {$mangaId}...");
        $mangaData = $this->service->getManga($mangaId);

        if (!$mangaData) {
            $this->error('Manga not found or API error.');
            return 1;
        }

        $attr = $mangaData['attributes'];
        $title = $attr['title']['en'] ?? reset($attr['title']);
        $slug = Str::slug($title);
        $description = $attr['description']['en'] ?? reset($attr['description']);
        
        $this->info("Syncing: {$title}...");

        // 1. Create or Update Manga
        $manga = Manga::updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $title,
                'description' => $description,
                'user_id' => 1, // Default Admin
                'status' => $attr['status'],
                'releaseDate' => $attr['year'],
                'alternative_titles' => json_encode($attr['altTitles']),
            ]
        );

        // 2. Handle Cover
        $coverUrl = $this->service->getCoverUrl($mangaData);
        if ($coverUrl) {
            $this->info('Downloading cover...');
            $coverContent = Http::withoutVerifying()->get($coverUrl)->body();
            $extension = pathinfo(parse_url($coverUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $coverName = uniqid() . '.' . $extension;
            $coverPath = "covers/{$coverName}";
            Storage::disk('public')->put($coverPath, $coverContent);
            $manga->update(['cover' => $coverName]);
        }

        // 3. Sync Tags/Genres
        $this->info('Syncing taxonomies...');
        foreach ($attr['tags'] as $tag) {
            $tagName = $tag['attributes']['name']['en'] ?? reset($tag['attributes']['name']);
            $tagSlug = Str::slug($tagName);
            
            $taxonomy = Taxonomy::firstOrCreate(
                ['slug' => $tagSlug, 'type' => 'genre'],
                ['title' => $tagName]
            );

            Taxable::firstOrCreate([
                'taxonomy_id' => $taxonomy->id,
                'taxable_id' => $manga->id,
                'taxable_type' => Manga::class
            ]);
        }

        // 4. Fetch Chapters
        $chaptersToSave = (int) $this->option('chapters');
        $this->info("Fetching chapters (searching for internal ones)...");
        // We fetch more than requested to skip external ones (MangaPlus, etc)
        $chapters = $this->service->getMangaFeed($mangaId, 100); 

        $savedCount = 0;
        foreach ($chapters as $chapterData) {
            if ($savedCount >= $chaptersToSave) break;

            $chAttr = $chapterData['attributes'];
            $chNum = $chAttr['chapter'] ?? 0;
            $chTitle = $chAttr['title'] ?? "Chapter {$chNum}";
            $pagesCount = $chAttr['pages'] ?? 0;

            if ($pagesCount == 0 || isset($chAttr['externalUrl'])) {
                continue; // Skip silently or with low-level debug if needed
            }
            
            $this->info("Processing Chapter {$chNum}: {$chTitle} ({$pagesCount} pages)...");
            $savedCount++;

            $chapter = Chapter::updateOrCreate(
                ['manga_id' => $manga->id, 'chapter_number' => $chNum],
                [
                    'title' => $chTitle,
                    'user_id' => 1,
                ]
            );

            // 5. Download Pages
            $pageData = $this->service->getChapterPages($chapterData['id']);
            if ($pageData) {
                $baseUrl = $pageData['baseUrl'];
                $hash = $pageData['chapter']['hash'];
                $fileNames = $pageData['chapter']['data']; // Original quality
                
                $localPagePaths = [];
                foreach ($fileNames as $index => $fileName) {
                    $pageUrl = "{$baseUrl}/data/{$hash}/{$fileName}";
                    $imageName = ($index + 1) . ".jpg";
                    $localPath = "content/{$slug}/{$chNum}/{$imageName}";
                    
                    if (!Storage::disk('public')->exists($localPath)) {
                        $this->info("  Downloading page " . ($index + 1) . "/" . count($fileNames));
                        try {
                            $pageContent = Http::withoutVerifying()->get($pageUrl)->body();
                            Storage::disk('public')->put($localPath, $pageContent);
                        } catch (Throwable $e) {
                            $this->error("  Failed to download page: {$e->getMessage()}");
                            continue;
                        }
                    }
                    $localPagePaths[] = $imageName;
                }
                
                $chapter->update(['content' => $localPagePaths]);
            }
        }

        $this->info('Sync completed successfully!');
        return 0;
    }
}
