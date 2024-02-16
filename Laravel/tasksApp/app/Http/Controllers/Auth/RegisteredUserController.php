<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Ajout de l'import pour la classe Role
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PendingUser;

use Illuminate\Support\Facades\Session;

use App\Notifications\UserRegistrationNotification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // On récupère l'id dont le nom est 'users'
    //     // $roles = Role::select('id')->where('name', 'maintenancier')->first();

    //     // Assigner le rôle 'users' à chaque nouvel utilisateur enregistré
    //     // if ($roles) {
    //     //     $user->roles()->attach($roles->id);
    //     // }



    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }


    public function store(Request $request, PendingUser $pendingUser)
    {



        // Recherche de l'utilisateur en attente d'approbation par email
        $pendingUser = PendingUser::where('email', $request->email)->first();
        // $user = User::where('email', $request->email)->first();


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);



        // Si un utilisateur est trouvé en attente d'approbation
        if ($pendingUser) {
            // return back()->with('status', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
            return redirect()->route('register')->with('error', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
        }

        // if ($user) {
        //     // return back()->with('status', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
        //     return redirect()->route('register')->with('error', 'Votre adhésion est en cours de traitement. Veuillez patienter.');
        // }



        // Validation des données et affiche des messages d'erreur si il y'a des erreurs
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . PendingUser::class],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . PendingUser::class, 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);






        // Création de l'utilisateur temporaire
        $pendingUser = PendingUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Assurez-vous de hacher le mot de passe correctement
        ]);


        // Recherche de l'utilisateur avec le rôle d'administrateur
        // Envoi de la notification à l'administrateur
        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'administrateur');
        })->first();

        // Vérifier si un administrateur a été trouvé
        if ($admin) {
            // Envoyer la notification à l'administrateur
            $admin->notify(new UserRegistrationNotification($pendingUser));
        }




        // $message = "Votre inscription est en cours de validation. Veuillez patienter pendant 24 heures.";
        // Session::flash('message', $message);

        // Redirection
        return redirect()->route('login')->with('success', 'Votre inscription a été soumise avec succès.');
    }



    // public function approveRegistration($id)
    // {
    //     $pendingUser = PendingUser::findOrFail($id);

    //     // Créer l'utilisateur dans la table principale des utilisateurs
    //     User::create([
    //         'name' => $pendingUser->name,
    //         'email' => $pendingUser->email,
    //         'password' => $pendingUser->password,
    //     ]);

    //     // Supprimer l'utilisateur en attente d'approbation de la table temporaire
    //     $pendingUser->delete();

    //     // Redirection

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }


    public function approveRegistration($id)
    {
        // Rechercher l'utilisateur en attente d'approbation
        $pendingUser = PendingUser::findOrFail($id);

        // Créer l'utilisateur dans la table principale des utilisateurs
        $user = User::create([
            'name' => $pendingUser->name,
            'email' => $pendingUser->email,
            'password' => $pendingUser->password,
        ]);

        // Supprimer l'utilisateur en attente d'approbation de la table temporaire
        $pendingUser->delete();




        // Connecter automatiquement l'utilisateur approuvé
        // Auth::login($user);

        // // Rediriger l'utilisateur vers la page d'accueil
        // return redirect(RouteServiceProvider::HOME);

        return redirect(RouteServiceProvider::HOME)->with('success', "Vous avez bien accepter la demande de" . ' ' . $pendingUser->name);
    }


    // public function showApproveRegistrationForm($id)
    // {
    //     $pendingUser = PendingUser::findOrFail($id);

    //     return view('admin.users.approveRegistration')->with('pendingUser', $pendingUser);
    // }


    public function showApproveRegistrationForm($id)
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Récupérer toutes les notifications non lues pour l'utilisateur
        $unreadNotifications = $user->unreadNotifications;

        // Récupérer l'utilisateur en attente
        $pendingUser = PendingUser::findOrFail($id);

        // Parcourir toutes les notifications non lues de l'utilisateur
        foreach ($unreadNotifications as $notification) {
            // Vérifier si la notification est associée à l'utilisateur en attente
            if ($notification->data['email'] == $pendingUser->email) {
                // Marquer la notification comme lue
                $notification->markAsRead();
            }
        }

        // Retourner la vue avec l'utilisateur en attente
        return view('admin.users.approveRegistration')->with('pendingUser', $pendingUser);
    }



    public function rejectRegistration($id)
    {
        // Rechercher l'utilisateur en attente par son ID
        $pendingUser = PendingUser::findOrFail($id);

        // Supprimer l'utilisateur en attente
        $pendingUser->delete();

        // Redirection ou réponse appropriée
        // return redirect()->route('admin.dashboard')->with('status', 'Inscription refusée avec succès.');

        return redirect(RouteServiceProvider::HOME)->with('success', "Vous avez refuser la demande de" . ' ' . $pendingUser->name);
    }
}
