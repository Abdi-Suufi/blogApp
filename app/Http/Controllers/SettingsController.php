<?php

// app/Http/Controllers/SettingsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        return view('settings');
    }

    /**
     * Update the user's name.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            $user->name = $request->name;
            $user->save();
        }

        return redirect()->route('settings.index')->with('success', 'Name updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        if ($user instanceof \Illuminate\Database\Eloquent\Model) {
            $user->delete();
        }

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
