<?php

// app/Http/Controllers/VerificationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class VerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify-email');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->email))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Your email is already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->route('home')->with('status', 'Your email has been verified.');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    }
}
