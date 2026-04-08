<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Manga;

class HomeController extends Controller
{
    /**
     * Homepage view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $twentyFourHoursAgo = Carbon::now()->subDay();

        $popular =
            Manga::withCount('views')
            ->whereHas('views', function ($query) use ($twentyFourHoursAgo) {
                $query->where('created_at', '>', $twentyFourHoursAgo);
            })
            ->orderByDesc('views_count')
            ->take(20)
            ->get();

        $sliders = Manga::with('slider')->whereHas('slider')->get();
        $latest = Manga::orderBy('created_at', 'desc')->fastPaginate(20);
        $chapters = Manga::whereHas('chapters')->orderBy('updated_at', 'desc')->fastPaginate(24)->appends(['chapters' => request()->input('chapters')]);

        return view('pages.home', compact('sliders', 'popular', 'latest', 'chapters'));
    }
}
