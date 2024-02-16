<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\PendingUser;



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
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }





    public function store(LoginRequest $request): RedirectResponse
    {
        // Recherche de l'utilisateur en attente d'approbation par email
        $pendingUser = PendingUser::where('email', $request->email)->first();

        // Si un utilisateur est trouvé en attente d'approbation
        if ($pendingUser) {
            // return back()->with('status', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
            return redirect()->route('login')->with('error', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
        }

        // Authentification normale avec les informations d'identification fournies
        $request->authenticate();

        // Régénérer la session après l'authentification
        $request->session()->regenerate();

        // Redirection vers la page d'accueil prévue
        return redirect()->intended(RouteServiceProvider::HOME);
    }




    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
