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
        $mangaIdOrTitle = $this->argument('manga_id');
        $chaptersToSave = (int) $this->option('chapters');

        if (!$mangaIdOrTitle) {
            $this->info('No input provided, fetching a random manga...');
            $randomManga = $this->service->getRandomManga();
            if (!$randomManga) {
                $this->error('Failed to fetch a random manga.');
                return 1;
            }
            $this->syncManga($randomManga['id'], $chaptersToSave);
            return 0;
        }

        if (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $mangaIdOrTitle)) {
            $this->syncManga($mangaIdOrTitle, $chaptersToSave);
            return 0;
        }

        $this->info("Searching for manga with title: {$mangaIdOrTitle}...");
        $searchResults = $this->service->searchManga($mangaIdOrTitle);
        if (empty($searchResults)) {
            $this->error('No manga found with that title.');
            return 1;
        }

        foreach ($searchResults as $index => $result) {
            $title = $result['attributes']['title']['en'] ?? reset($result['attributes']['title']);
            $this->info("Result #" . ($index + 1) . ": " . $title . " (" . $result['id'] . ")");
            
            // Check if it has any hosted (non-external) English chapters before committing
            $chapters = $this->service->getMangaFeed($result['id'], 5); 
            $hostedChapters = array_filter($chapters, function($ch) {
                return !isset($ch['attributes']['externalUrl']) && ($ch['attributes']['pages'] ?? 0) > 0;
            });

            if (count($hostedChapters) > 0) {
                $this->info("  Found " . count($hostedChapters) . " hosted chapters for '{$title}', starting sync...");
                $this->syncManga($result['id'], $chaptersToSave);
                return 0;
            }
            
            $this->warn("  No downloadable English chapters found for this version, checking next...");
        }

        $this->error('No versions with English chapters found.');
        return 1;
    }

    protected function syncManga($mangaId, $chaptersToSave)
    {
        $this->info("Fetching data for Manga: {$mangaId}...");
        $mangaData = $this->service->getManga($mangaId);

        if (!$mangaData) {
            $this->error('Manga not found or API error.');
            return;
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
            try {
                $coverContent = Http::withoutVerifying()->get($coverUrl)->body();
                $extension = pathinfo(parse_url($coverUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $coverName = uniqid() . '.' . $extension;
                $coverPath = "covers/{$coverName}";
                Storage::disk('public')->put($coverPath, $coverContent);
                $manga->update(['cover' => $coverName]);
            } catch (Throwable $e) {
                $this->warn("Failed to download cover: {$e->getMessage()}");
            }
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
        $this->info("Fetching chapters...");
        $chapters = $this->service->getMangaFeed($mangaId, 100); 
        $this->info("Found " . count($chapters) . " potential chapters.");

        $savedCount = 0;
        foreach ($chapters as $chapterData) {
            if ($savedCount >= $chaptersToSave) break;

            $chAttr = $chapterData['attributes'];
            $chNum = $chAttr['chapter'] ?? 0;
            $chTitle = $chAttr['title'] ?? "Chapter {$chNum}";
            $pagesCount = $chAttr['pages'] ?? 0;

            if (isset($chAttr['externalUrl'])) {
                $this->line("  Skipping Chapter {$chNum} (External Link)");
                continue;
            }

            if ($pagesCount == 0) {
                $this->line("  Skipping Chapter {$chNum} (No pages)");
                continue;
            }
            
            $this->info("Processing Chapter {$chNum}: {$chTitle} ({$pagesCount} pages)...");

            // Create chapter record first to get ID if needed, though we sync by number here
            $chapter = Chapter::updateOrCreate(
                ['manga_id' => $manga->id, 'chapter_number' => $chNum],
                [
                    'title' => $chTitle,
                    'user_id' => 1,
                ]
            );

            // 5. Download Pages
            $pageData = $this->service->getChapterPages($chapterData['id']);
            if ($pageData && isset($pageData['baseUrl'], $pageData['chapter'])) {
                $baseUrl = $pageData['baseUrl'];
                $hash = $pageData['chapter']['hash'];
                $fileNames = $pageData['chapter']['data']; // Original quality
                
                $localPagePaths = [];
                foreach ($fileNames as $index => $fileName) {
                    $pageUrl = "{$baseUrl}/data/{$hash}/{$fileName}";
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION) ?: 'jpg';
                    $imageName = ($index + 1) . "." . $extension;
                    $localPath = "content/{$slug}/{$chNum}/{$imageName}";
                    
                    if (!Storage::disk('public')->exists($localPath)) {
                        try {
                            $this->line("    Downloading page " . ($index + 1) . "...");
                            $pageResponse = Http::timeout(30)->withoutVerifying()->get($pageUrl);
                            if ($pageResponse->successful()) {
                                Storage::disk('public')->put($localPath, $pageResponse->body());
                            } else {
                                $this->error("      Failed to download page " . ($index + 1) . ": HTTP " . $pageResponse->status());
                            }
                        } catch (Throwable $e) {
                            $this->error("      Exception downloading page " . ($index + 1) . ": {$e->getMessage()}");
                        }
                    }
                    $localPagePaths[] = $imageName;
                }
                
                $chapter->update(['content' => $localPagePaths]);
                $savedCount++;
            } else {
                $this->error("  Failed to fetch page data for Chapter {$chNum}");
            }
        }

        $this->info('Sync completed successfully!');
    }
}
