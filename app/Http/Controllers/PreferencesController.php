<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PreferencesController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:light,dark'],
            'preferred_language' => ['required', 'in:en,bn'],
            'dashboard_layout' => ['required', 'in:comfortable,compact'],
        ]);

        $lifetime = 60 * 24 * 30;

        return redirect()
            ->route('dashboard')
            ->with('success', 'Preferences saved. Cookies now remember your theme, language, and dashboard layout.')
            ->withCookie(cookie('theme', $validated['theme'], $lifetime))
            ->withCookie(cookie('preferred_language', $validated['preferred_language'], $lifetime))
            ->withCookie(cookie('dashboard_layout', $validated['dashboard_layout'], $lifetime));
    }

    public function destroy(Request $request): RedirectResponse
    {
        return redirect()
            ->route('dashboard')
            ->with('success', 'Preferences cleared.')
            ->withCookie(Cookie::forget('theme'))
            ->withCookie(Cookie::forget('preferred_language'))
            ->withCookie(Cookie::forget('dashboard_layout'));
    }
}
