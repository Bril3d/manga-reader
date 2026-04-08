<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Show the user settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.user');
    }

    /**
     * Update the user avatar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the request data
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        // Update avatar if provided
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $image = $request->file('avatar');
            $imageName = uniqid() . '.webp';
            $imgData = Image::read($image)->scale(width: 200)->encodeByExtension('webp', quality: settings()->get('quality'));
            Storage::put('/public/avatars/' . $imageName, $imgData);

            $user->avatar = $imageName;
        } else {
            return redirect()->back()->with('error', 'Please provide an image.');
        }


        // Save the user's changes
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Destroy the authenticated user's session and keep language, darkMode and logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        Session::keep(['language', 'darkMode']);

        return redirect()->route('home')->with('success', __('Logged out successfully.'));
    }
}
