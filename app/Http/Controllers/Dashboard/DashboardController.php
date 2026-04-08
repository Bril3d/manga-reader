<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\File;

class DashboardController
{
    /**
     * Display the dashboard index page.
     *
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        abort_unless(auth()->user()->can('view_dashboard'), 403);

        $statistics = [
            'mangas' => Manga::count(),
            'chapters' => Chapter::count(),
            'users' => User::count(),
            'genres' => Taxonomy::where('type', 'genre')->count(),
            'mangasViews' => Manga::getTotalViews(),
            'chaptersViews' => Chapter::getTotalViews(),
            'users_labels' => [],
            'users_data' => [],
            'mangas_labels' => [],
            'mangas_data' => [],
            'chapters_labels' => [],
            'chapters_data' => [],
        ];

        $storageStatistics = $this->getStorageStatistics();

        $this->generateUserRegistrationChartData($statistics);
        $this->generateChapterViewsChartData($statistics);
        $this->generateMangaViewsChartData($statistics);

        return view('dashboard.index', array_merge($statistics, $storageStatistics));
    }

    /**
     * Generate the user registration chart data.
     *
     * @param  array  &$statistics
     * @return void
     */
    private function generateUserRegistrationChartData(array &$statistics)
    {
        $userRegistrations = User::select('created_at')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6)->toDateString()) // Retrieve data for the last 7 days
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($user) {
                return $user->created_at->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->count();
            });

        $statistics['users_labels'] = $userRegistrations->keys()->toArray();
        $statistics['users_data'] = $userRegistrations->values()->toArray();
    }

    /**
     * Generate the chapter views chart data.
     *
     * @param  array  &$statistics
     * @return void
     */
    private function generateChapterViewsChartData(array &$statistics)
    {
        $chapterViews = Chapter::with('views')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6)->toDateString())
            ->get()
            ->map(function ($chapter) {
                $views = $chapter->views
                    ->groupBy(function ($view) {
                        return $view->created_at->toDateString();
                    })
                    ->map(function ($group) {
                        return $group->count();
                    });
                return [
                    'chapter' => $chapter,
                    'views' => $views,
                ];
            });

        $statistics['chapters_labels'] = $chapterViews->pluck('views')->collapse()->keys()->toArray();
        $statistics['chapters_data'] = collect($statistics['chapters_labels'])->map(function ($label) use ($chapterViews) {
            return $chapterViews->sum(function ($item) use ($label) {
                return $item['views']->get($label, 0);
            });
        })->values()->toArray();
    }

    /**
     * Generate the manga views chart data.
     *
     * @param  array  &$statistics
     * @return void
     */
    private function generateMangaViewsChartData(array &$statistics)
    {
        $mangaViews = Manga::with('views')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(6)->toDateString())
            ->get()
            ->map(function ($manga) {
                $views = $manga->views
                    ->groupBy(function ($view) {
                        return $view->created_at->toDateString();
                    })
                    ->map(function ($group) {
                        return $group->count();
                    });
                return [
                    'manga' => $manga,
                    'views' => $views,
                ];
            });

        $statistics['mangas_labels'] = $mangaViews->pluck('views')->collapse()->keys()->toArray();
        $statistics['mangas_data'] = collect($statistics['mangas_labels'])->map(function ($label) use ($mangaViews) {
            return $mangaViews->sum(function ($item) use ($label) {
                return $item['views']->get($label, 0);
            });
        })->values()->toArray();
    }

    /**
     * Get storage statistics, including total size, formatted size, and percentage used.
     *
     * @return array
     */
    private function getStorageStatistics()
    {
        $folderPath = storage_path('app/public');
        $totalSize = 0;

        if (File::isDirectory($folderPath)) {
            $files = File::allFiles($folderPath);

            foreach ($files as $file) {
                $totalSize += $file->getSize();
            }
        }

        $formattedSize = $this->formatSizeUnits($totalSize);
        $freeSpace = disk_total_space(storage_path());
        $percentageUsed = round(($totalSize / $freeSpace) * 100);

        return [
            'size' => $formattedSize,
            'percentageUsed' => $percentageUsed,
        ];
    }

    /**
     * Format the given file size in human-readable units.
     *
     * @param  int  $bytes
     * @return string
     */
    private function formatSizeUnits($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }
}
