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
    public function searchManga($title, $limit = 1)
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/manga", [
            'title' => $title,
            'limit' => $limit,
            'includes' => ['cover_art']
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
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
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/manga/{$mangaId}", [
            'includes' => ['cover_art', 'author', 'artist']
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }

    /**
     * Get chapter feed for a manga
     */
    public function getMangaFeed($mangaId, $limit = 10)
    {
        $response = Http::withoutVerifying()->get("{$this->baseUrl}/manga/{$mangaId}/feed", [
            'limit' => $limit,
            'translatedLanguage' => ['en'],
            'order' => ['publishAt' => 'desc'],
            'contentRating' => ['safe', 'suggestive', 'erotica'],
            'includeExternalUrl' => 1
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

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
