<?php

// app/Http/Controllers/SettingsController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
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
        $user = Auth::user();
        Auth::logout();

        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $user->delete();
        }

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
