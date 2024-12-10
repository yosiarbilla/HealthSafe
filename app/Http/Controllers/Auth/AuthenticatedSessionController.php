<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    // Redirect based on user role
    if ($request->user()->role === 'administrasi') {
        return redirect()->route('admin.dashboard');
    } elseif ($request->user()->role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    } elseif ($request->user()->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }
    // Default redirect if no role matches
    return redirect()->route('dashboard');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
