<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Show the Menus list page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $menus = Menu::orderBy('created_ar', 'desc')->paginate(20);
        return view('dashboard.settings.menus.index', compact('menus'));
    }

    /**
     * Update the theme settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $setting = $request->validate([
            'theme_active' => 'required',
            'theme_mode' => 'required|in:light,dark',
            'theme_slider' => 'required|in:enabled,disabled',
        ]);

        settings()->set('theme.active', $setting['theme_active']);
        settings()->set('theme.mode', $setting['theme_mode']);
        settings()->set('theme.slider', $setting['theme_slider']);

        return back()->with('success', __('Theme settings have been updated'));
    }
}
