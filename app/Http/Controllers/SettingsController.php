<?php

// app/Http/Controllers/SettingsController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->name = $request->name;

            if ($request->hasFile('profile_picture')) {
                // Delete the old profile picture if it exists
                if ($user->profile_picture) {
                    Storage::delete($user->profile_picture);
                }
                // Store the new profile picture
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $path;
            }

            $user->save();
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        if ($user) {
            $user->delete(); // Delete the user
            Auth::logout(); // Log the user out
            return redirect()->route('posts.index')->with('status', 'Account deleted successfully.');
        }

        return redirect()->back()->withErrors(['error' => 'Unable to delete account.']);
    }
}
