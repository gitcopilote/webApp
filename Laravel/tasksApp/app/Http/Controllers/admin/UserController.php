<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Role; // Assurez-vous que vous utilisez le bon namespace pour le modèle Role
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        // Récupère tous les utilisateurs avec leurs rôles associés
        $users = User::with('roles')->get();

        // Retourne la vue 'admin.users.index' avec les utilisateurs récupérés
        return view('admin.users.index', [
            "users" => $users
        ]);
    }

    public function edit(User $user)
    {
        // Utilisation de findOrFail pour s'assurer que l'utilisateur existe
        $user->load('roles');
        $roles = Role::all(); // Assurez-vous que le modèle Role est correctement inclus

        return view('admin.users.edit', [
            "user" => $user, // Utilisation de $user au singulier
            "roles" => $roles
        ]);
    }


    public function update(User $user, Request $request)
    {
       $request->validate(

        [
            'roles' => ['array', 'exists:roles,id']
        ]
       );

       $user->roles()->sync($request->input('roles'));
    //    return redirect()->route('admin.users.index');

       return redirect()->route('admin.users.index', ['user' => $user->id])->with('success','Le role de ' .$user->name . ' à été modifier avec succès.');
    }


    public function delete(User $user)
    {
    // Supprime l'utilisateur
    $user->delete();

    // Redirige vers la liste des utilisateurs ou une autre page appropriée
    // return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');

    return redirect()->route('admin.users.index', ['user' => $user->id])->with('success', $user->name . ' est été supprimé avec succès.');
   }
}
