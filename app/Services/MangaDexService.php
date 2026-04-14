<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MangaDexService
{
    protected $baseUrl = 'https://api.mangadex.org';

    /**
     * Search for manga by title
     */
    public function searchManga($title, $limit = 5)
    {
        $url = "{$this->baseUrl}/manga?" . http_build_query([
            'title' => $title,
            'limit' => $limit
        ]);
        $url .= "&includes[]=cover_art";

        $response = Http::withoutVerifying()->get($url);

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }

        return [];
    }

    /**
     * Get a random manga
     */
    public function getRandomManga()
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/manga/random");
        
        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }

    /**
     * Get manga details by ID
     */
    public function getManga($mangaId)
    {
        $url = "{$this->baseUrl}/manga/{$mangaId}?includes[]=cover_art&includes[]=author&includes[]=artist";
        $response = Http::withoutVerifying()->get($url);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        Log::error("MangaDex API Error (getManga) for ID {$mangaId}: " . $response->status() . " - " . $response->body());
        return null;
    }

    /**
     * Get chapter feed for a manga
     */
    public function getMangaFeed($mangaId, $limit = 10)
    {
        // Using a more manual approach for array params to avoid [0] indices
        $queryParams = [
            'limit' => $limit,
            'order[publishAt]' => 'desc',
            'includeExternalUrl' => 0
        ];
        
        $url = "{$this->baseUrl}/manga/{$mangaId}/feed?" . http_build_query($queryParams);
        $url .= "&translatedLanguage[]=en";
        $url .= "&contentRating[]=safe&contentRating[]=suggestive&contentRating[]=erotica&contentRating[]=pornographic";

        $response = Http::withoutVerifying()->get($url);

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }

        Log::error("MangaDex API Error (getMangaFeed): " . $response->status() . " - " . $response->body());
        return [];
    }

    /**
     * Get chapter pages
     */
    public function getChapterPages($chapterId)
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/at-home/server/{$chapterId}");

        if ($response->successful()) {
            return $response->json();
        }

        Log::error("MangaDex API Error (getChapterPages): " . $response->status() . " - " . $response->body());
        return null;
    }

    /**
     * Get cover image URL
     */
    public function getCoverUrl($manga)
    {
        $coverFileName = null;
        foreach ($manga['relationships'] as $rel) {
            if ($rel['type'] === 'cover_art') {
                $coverFileName = $rel['attributes']['fileName'] ?? null;
                break;
            }
        }

        if ($coverFileName) {
            return "https://uploads.mangadex.org/covers/{$manga['id']}/{$coverFileName}";
        }

        return null;
    }
}
