<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

use Mpdf\Mpdf;
use App\Models\Staff;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use App\Notifications\HistoricalNotification;

class HistoryController extends Controller
{
    /**
     * Affiche la liste des actions historiques.
     *
     * @return \Illuminate\Http\Response
     */
    public function historyIndex()
    {


        $histories = History::all();

        return view('histories.historyIndex', compact('histories'));
    }

    /**
     * Affiche les détails d'une action historique spécifique.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */


    // public function show(History $history)
    // {
    //     return view('histories.show', compact('history'));
    // }



    /**
     * Supprime une action historique spécifique.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroyHistory()
    {
        History::truncate();

        // return redirect()->route('histories.index')->with('success', 'L\'historique a été supprimée avec succès.');

        return redirect()->back()->with('success', "L'historique a été supprimée avec succès");
    }

    // génération de pdf

    public function documentPdf()
    {
        // Récupère les données nécessaires depuis la base de données
        $histories = History::orderBy('name', 'asc')->get();

        // Crée une instance de mPDF
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        // $mpdf = new \Mpdf\Mpdf();
        // $mpdf->showImageErrors = true;
        // $mpdf->curlAllowUnsafeSslRequests = true;

        // Capture le rendu HTML de la vue
        $html = View::make('histories.balanceSheet', ['histories' => $histories])->render();

        // Ajoute le contenu HTML à mPDF
        $mpdf->WriteHTML($html);

        // Génère le PDF et le renvoie au navigateur
        $mpdf->Output('Bilan.pdf', 'D');
    }


    public function show($historyId)
    {
        // Récupérer l'historique à partir de la base de données
        $history = History::find($historyId);

        // Vérifier si l'historique existe
        if (!$history) {
            // Gérer le cas où l'historique n'est pas trouvé, par exemple, rediriger vers une page d'erreur.
            return redirect()->route('error.page')->with('error', 'History not found');
        }

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Passer l'historique à la vue et afficher la page
        return view('histories.show', compact('history'));
    }



    // public function sendAdminNotification()
    // {
    //     // Récupérer les utilisateurs avec le rôle administrateur
    //     $AdminRole = User::whereHas('roles', function ($query) {
    //         $query->where('name', 'administrateur');
    //     })->get();

    //     // Envoyer la notification à chaque utilisateur administrateur
    //     // foreach ($AdminRole as $admin) {
    //     //     $admin->notify(new HistoricalNotification($AdminRole));
    //     // }

    //    // Envoyer la notification à chaque utilisateur administrateur
    //     foreach ($AdminRole as $admin) {
    //         $admin->notify(new HistoricalNotification($admin));
    //     }
    // }

}
