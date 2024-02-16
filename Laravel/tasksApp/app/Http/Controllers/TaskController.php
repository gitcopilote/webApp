<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Breakdown;
use App\Models\Location;
use App\Models\Task;
use App\Models\User;
use App\Models\History;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskTerminedNotification;
use Illuminate\Support\Carbon;




class TaskController extends Controller
{
    //

    public function index()
    {

        $tasks = Auth::user()->created_task;

        //nom du dossier point non du fichier pour afficher le fichier concerné
        return View('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    // public function MyTask()
    // {
    //     // return View('tasks.TaskAssigned');

    //     $tasks = Auth::user()->assigned;
    //     $user = User::all(); // Récupère tous les utilisateurs
    //     //nom du dossier point non du fichier pour afficher le fichier concerné
    //     return View('tasks.TaskAssigned', [
    //         'tasks' => $tasks,
    //         'users' => $user
    //     ]);
    // }


    public function MyTask()
    {
        // Récupérer toutes les tâches assignées à l'utilisateur actuellement authentifié
        $tasks = Auth::user()->assigned;

        // Récupérer tous les utilisateurs ayant le rôle de "maintenancier"
        // $users = User::whereHas('roles', function ($query) {
        //     $query->where('name', 'maintenancier');
        // })->get();


        // Récupérer tous les utilisateurs ayant le rôle de "maintenancier" sauf l'utilisateur qui est connecter
        $currentUser = Auth::user();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'maintenancier');
        })
            ->where('id', '!=', $currentUser->id) // Exclure l'utilisateur actuel
            ->get();


        // Retourner la vue avec les tâches et les utilisateurs récupérés
        return view('tasks.TaskAssigned', compact('tasks', 'users'));
    }


    public function create()
    {
        $breakdowns = Breakdown::all(); // Récupérer toutes les pannes
        $locations = Location::all();   // Récupérer tous les lieux

        $tasks = Auth::user()->assigned;

        //nom du dossier point non du fichier pour afficher le fichier concerné
        return view('tasks.create', [
            'tasks' => $tasks,
            'breakdowns' => $breakdowns,
            'locations' => $locations,
        ]);
    }


    // public function edit()
    // {

    //     $tasks = Auth::user()->assigned;
    //     return View('tasks.edit',[
    //         'tasks' => $tasks
    //     ]);
    // }


    public function edit(Task $task)
    {
        $breakdowns = Breakdown::all(); // Récupérer toutes les pannes
        $locations = Location::all();   // Récupérer tous les lieux

        // $tasks = Auth::user()->assigned;

        //nom du dossier point non du fichier pour afficher le fichier concerné
        return View('tasks.edit', [
            'task' => $task,
            'breakdowns' => $breakdowns,
            'locations' => $locations,
        ]);
    }


    public function alltasks(Task $task)
    {

        // Récupère toutes les tâches créées par tous les utilisateurs
        $tasks = Task::all();

        // Renvoie les tâches à la vue 'tasks.index' pour les afficher
        return view('tasks.alltasks', ['tasks' => $tasks]);
    }




    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([

            // 'breakdown' => ['required', 'min:3'],
            // 'location' => ['required', 'min:3'],
            'breakdown' => ['required'],
            'location' => ['required'],
            // 'start_date' => ['required', 'date','after:tomorrow'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            // 'due_date' => ['required', 'date','after:start_date'],
            'due_date' => ['nullable', 'date', 'after:start_date'],
            // 'description' => ['required', 'min:5'],
            'description' => ['required'],
        ]);

        Task::create([
            'name' => $request->input('breakdown'),
            'place' => $request->input('location'),
            'start_date' => $request->input('start_date'),
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
            'user_created_by' => Auth::user()->id

        ]);

        return redirect()->route('task.index')->with('success', 'votre tache à bien été créer');
    }


    //soit store ou store en dessous sans  créer une rquest pour intégré la validation du formulaire l'ors de la creation

    // public function store(taskRequest $request)
    // {
    //     // dd($request->all());


    //     Task::create([
    //         'name'=> $request->input('breakdown'),
    //         'place'=> $request->input('location'),
    //         'start_date'=> $request->input('start_date'),
    //         'due_date'=> $request->input('due_date'),
    //         'description'=> $request->input('description'),
    //         'user_created_by' => Auth::user()->id

    //     ]);
    //     return redirect()->route('task.index')->with('success','votre tache à bien été créer');
    // }





    public function update(Task $task, Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'place' => ['required'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'due_date' => ['nullable', 'date', 'after:start_date'],
            'description' => ['required'],
        ]);

        $task->update($request->all()); // Correction ici
        return redirect()->route('task.index')->with('success', 'Votre tâche a bien été modifiée');
    }

    // public function updated(Task $task, Request $request)
    // {
    //     $request->validate([
    //         'name' => ['required'],
    //         'place' => ['required'],
    //         'start_date' => ['required', 'date', 'after_or_equal:today'],
    //         'due_date' => ['nullable', 'date', 'after:start_date'],
    //         'description' => ['required'],
    //         'status' => ['required'],
    //     ]);

    //     $task->update($request->all()); // Correction ici
    //     return redirect()->route('task.alltasks')->with('success', 'Votre tâche a bien été modifiée');
    // }



    //     public function updated(Task $task, Request $request)
    // {

    //     $request->validate([
    //         'name' => ['required'],
    //         'place' => ['required'],
    //         'start_date' => ['required', 'date', 'after_or_equal:today'],
    //         'due_date' => ['nullable', 'date', 'after:start_date'],
    //         'description' => ['required'],
    //         'status' => ['required'],
    //     ]);

    //     $selectedbreakdown = $request->input('breakdown');
    //     $selectedlocation = $request->input('location');
    //     // Extraire la valeur du champ 'status' de la requête
    //     $selectedStatus = $request->input('status');

    //     // Mettre à jour les autres champs de la tâche
    //     $task->update($request->all());

    //    // Mettre à jour le champ 'status' avec la valeur extraite
    //    $task->status = $selectedStatus;
    //    $task->save();
    //    $task->name = $selectedbreakdown;
    //    $task->save();
    //    $task->place = $selectedlocation;
    //    $task->save();
    //     return redirect()->route('task.alltasks')->with('success', 'Votre tâche a bien été modifiée');
    // }



    public function updated(Task $task, Request $request)
    {
        $request->validate([
            'breakdown' => ['required'],
            'location' => ['required'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'due_date' => ['nullable', 'date', 'after:start_date'],
            'description' => ['required'],
            'status' => ['required'],
        ]);

        $task->update([
            'name' => $request->input('breakdown'),
            'place' => $request->input('location'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'due_date' => $request->input('due_date'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('task.alltasks')->with('success', 'Votre tâche a bien été modifiée');
    }


















    //soit update ou update en dessous sans avoir à quest pour intégré la validation du formulaire l'ors du update

    // public function update(Task $task, taskRequest $request)
    // {
    //     $task->update($request->validate());
    //     return redirect()->route('task.index')->with('success', 'Votre tâche a bien été modifiée');
    // }



    public function remove(task $task)
    {
        $task->delete();
        return redirect()->route('task.index')->with('success', 'Votre tâche a bien été supprimer');
    }




    public function removed(task $task)
    {
        $task->delete();
        return redirect()->route('task.alltasks')->with('success', 'Votre tâche a bien été supprimer');
    }





    public function assignedView(task $task)
    {
        // $users = User::whereDoesntHave('roles', function (Builder $query) {
        //     $query->whereIn('name', ['administrateur', 'magasinier']);
        // })->get();

        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('name', 'maintenancier');
        })->get();


        // ...

        return view('tasks.assigned', compact('users', 'task'));
    }



    public function assignedViews(task $task)
    {
        // $users = User::whereDoesntHave('roles', function (Builder $query) {
        //     $query->whereIn('name', ['administrateur', 'magasinier']);
        // })->get();

        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('name', 'maintenancier');
        })->get();


        // ...

        return view('tasks.allassigned', compact('users', 'task'));
    }






    // public function show($taskId)
    // {
    //     // Récupérer la tâche à partir de la base de données avec la relation user chargée
    //     $task = Task::with('user')->find($taskId);

    //     // Vérifier si la tâche existe
    //     if (!$task) {
    //         // Gérer le cas où la tâche n'est pas trouvée, rediriger, afficher une erreur, etc.
    //         return redirect()->route('task.show');
    //     }

    //     // Passer la tâche à la vue et afficher la page
    //     return view('tasks.show', compact('task'));
    // }


    // public function show(Task $task)
    // {
    //     $user = User::find(Auth::user()->id);

    //     $notification = $user->notifications()->where(function($query) use ($task) {
    //         $query->where('data->task_id', $task->id)
    //               ->where('read_at', null);

    //     })->first();

    //     if ($notification) {
    //         $notification->markAsRead();
    //     }
    //     return view('tasks.show', compact('task'));
    // }



    public function show($taskId)
    {
        // Récupérer la tâche à partir de la base de données avec la relation user chargée
        $task = Task::with('user')->find($taskId);

        // Vérifier si la tâche existe


        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Récupérer toutes les notifications non lues pour l'utilisateur
        $unreadNotifications = $user->unreadNotifications;

        // Marquer toutes les notifications non lues associées à la tâche comme lues
        foreach ($unreadNotifications as $notification) {
            if ($notification->data['task_id'] == $task->id) {
                $notification->markAsRead();
            }
        }

        // Passer la tâche à la vue et afficher la page
        return view('tasks.show', compact('task'));
    }







    // public function assign(Request $request , Task $task)
    // {
    //     $request->validate([
    //         'user_assigned_to' => ['required', 'exists:users,id'],
    //     ]);

    //     $user_assigned_to = $request->input('user_assigned_to');

    //     //voir si le maintenancier est disponible ou pas

    //     $occuped = User::findOrFail($user_assigned_to)->assigned()
    //     ->where(function (Builder $query) use($task) {

    //         //bonne requette $query->where('status', 'assigné');
    //            $query->where('status', 'nouveau')
    //            ->where('start_date','<',$task->due_date)
    //            ->where('start_date','>',$task->start_date)
    //     })->get();

    //     // dd($occuped);
    // }



    // public function assign(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'user_assigned_to' => ['required', 'exists:users,id'],
    //     ]);

    //     $user_assigned_to = $request->input('user_assigned_to');

    //     // Vérifier si le maintenancier est disponible ou non
    //     $user = User::findOrFail($user_assigned_to);
    //     $occupied = $user->assigned()
    //         ->where(function (Builder $query) use ($task) {
    //             $query->where('status', 'nouveau')
    //                 ->where('start_date', '<', $task->due_date)
    //                 ->where('due_date', '>', $task->start_date);
    //         })->exists();



    //     if ($occupied) {
    //         return redirect()->route('task.index', ['assign' => $task->id])->with('error', 'Le maintenancier ' . $user->name . ' est occupé pour cette période');
    //     }else {
    //         $task->user_assigned_to = $user_assigned_to;
    //         $task->status =  'nouveau';
    //         $task->save();

    //         return redirect()->route('task.assign', ['task' => $task->id])->with('success', $user->name . ' est assigner à cette tache');
    //     }

    // }





    public function assign(Request $request, Task $task)
    {


        $request->validate([
            'user_assigned_to' => ['required', 'exists:users,id'],
        ]);

        $user_assigned_to = $request->input('user_assigned_to');

        // Vérifier si le maintenancier est disponible ou non
        // $user = User::findOrFail($user_assigned_to);
        // $occupied = $user->assigned()
        // ->where(function (Builder $query) use ($task) {
        //     $query->where('status', 'assigner')
        //         ->where('start_date', '<', $task->due_date)
        //         ->where('due_date', '>', $task->start_date);
        // })->exists();



        // Vérifier si le maintenancier est disponible ou non
        $user = User::findOrFail($user_assigned_to);

        // Si la date d'échéance est vide, nous n'avons pas besoin de vérifier les chevauchements de date
        if (empty($task->due_date)) {
            $occupied = false;
        } else {
            $occupied = $user->assigned()
                ->where(function (Builder $query) use ($task) {
                    $query->where('status', 'assigner')
                        ->where('start_date', '<', $task->due_date)
                        ->where('due_date', '>', $task->start_date);
                })->exists();
        }

        // Reste du code inchangé...




        if ($occupied) {
            return redirect()->route('task.assignedView', ['task' => $task->id])->with('error', 'Le maintenancier ' . $user->name . ' est occupé pour cette période');
        } else {
            $task->user_assigned_to = $user_assigned_to;
            $task->status =  'assigner';
            $task->save();
            $user->notify(new TaskAssignedNotification($task));
            return redirect()->route('task.index', ['task' => $task->id])->with('success', $user->name . ' est assigner à cette tache');
        }
    }




    public function assigned(Request $request, Task $task)
    {

        $request->validate([
            'user_assigned_to' => ['required', 'exists:users,id'],
        ]);

        $user_assigned_to = $request->input('user_assigned_to');

        // Vérifier si le maintenancier est disponible ou non
        $user = User::findOrFail($user_assigned_to);
        $occupied = $user->assigned()
            ->where(function (Builder $query) use ($task) {
                $query->where('status', 'nouveau')
                    ->where('start_date', '<', $task->due_date)
                    ->where('due_date', '>', $task->start_date);
            })->exists();



        if ($occupied) {
            return redirect()->route('task.assign', ['task' => $task->id])->with('error', 'Le maintenancier ' . $user->name . ' est occupé pour cette période');
        } else {


            $task->user_assigned_to = $user_assigned_to;
            $task->status =  'nouveau';
            $task->save();

            return redirect()->route('task.assign', ['task' => $task->id])->with('success', $user->name . ' est assigner à cette tache');
        }
    }



    //boutton marquer comme terminer
    public function startTask(Task $task)
    {
        // Mettre à jour le statut en "Terminer" si le statut actuel est différent
        $task->status = 'En cours';
        // Enregistrer les modifications
        $task->save();
        return redirect()->route('task.MyTask');
    }


    // public function maskAsTermined(Task $task)
    // {

    //     $user = User::find($task->user_created_by);
    //     // Mettre à jour le statut en "Terminer" si le statut actuel est différent
    //     $task->status = 'Terminer';
    //     // Enregistrer les modifications
    //     $task->save();

    //     // $task->delete();

    //     $user->notify(new TaskTerminedNotification($task));

    //     return redirect()->back()->with('success', "Merci d'avoir terminer votre tache");

    //     // return redirect()->route('task.MyTask', ['task' => $task->id])->with('success', $task->name . " Merci d'avoir terminer votre tache");
    //     // return redirect()->route('task.MyTask');
    // }


    public function maskAsTermined(Request $request, Task $task)
    {
        $request->validate([
            'resolved' => ['required'],
        ]);

        // Récupérer l'utilisateur qui a créé la tâche
        $user = User::find($task->user_created_by);

        // Récupérer l'utilisateur à qui la tâche est assignée
        $userAssignedTo = User::find($task->user_assigned_to);


        $task->status = $request->input('selected_status');
        $task->MaintenanceAssistant = $request->input('MaintenanceAssistant');
        $task->resolved = $request->input('resolved');
        $task->save();

        // $task->status = $selectedStatus;
        // $task->save();

        // Enregistrer les informations dans la table History
        History::create([
            'user' =>  $userAssignedTo->name,
            'name' => $task->name,
            'place' => $task->place,
            'description' => $task->description,
            'start_date' => $task->start_date,
            'due_date' => $task->due_date,
            'status' => $task->status,
            'MaintenanceAssistant' =>  $task->MaintenanceAssistant,
            'resolved' => $task->resolved,
            // ou $task->status si vous voulez récupérer le statut actuel
        ]);

        // Envoyer une notification à l'utilisateur
        $user->notify(new TaskTerminedNotification($task));

        // $user->notify(new TaskTerminedNotification($task));

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', "les informatoions de cette tache à été mise à jour avec succès");
    }





    public function unassign(Request $request, $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            // Récupérer l'utilisateur assigné à la tâche
            $assignedUser = $task->user;

            if ($assignedUser) {
                // Désassigner l'utilisateur de la tâche actuelle
                $task->user_assigned_to = null;
                $task->status = 'désassigné';

                // Enregistrer les modifications
                $task->save();

                return redirect()->route('task.index', ['task' => $task->id])->with('success', 'La tâche ' . $task->name . ' a été désassignée avec succès');
            } else {
                // Aucun utilisateur assigné à la tâche
                return redirect()->route('task.index', ['task' => $task->id])->with('error', 'Impossible de désassigner la tache ' . $task->name . ' car elle n\'est assignée à aucun maintenancier.');
            }
        } catch (\Exception $e) {
            // Gérer l'exception (par exemple, si la tâche n'est pas trouvée)
            return redirect()->route('task.index')->with('error', 'La tâche spécifiée n\'existe pas.');
        }
    }


    public function unassigned(Request $request, $taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            // Récupérer l'utilisateur assigné à la tâche
            $assignedUser = $task->user;

            if ($assignedUser) {
                // Désassigner l'utilisateur de la tâche actuelle
                $task->update([
                    'user_assigned_to' => null,
                    'status' => 'nouveau',
                ]);
                return redirect()->route('task.alltasks', ['task' => $task->id])->with('success', 'La tâche ' . $task->name . ' a été désassignée avec succès');
            } else {
                // Aucun utilisateur assigné à la tâche
                return redirect()->route('task.alltasks', ['task' => $task->id])->with('error', 'Impossible de désassigner la tache ' . $task->name . ' car elle n\'est assigné à aucun maintenancier.');
            }
        } catch (\Exception $e) {
            // Gérer l'exception (par exemple, si la tâche n'est pas trouvée)
            return redirect()->route('task.alltasks')->with('error', 'La tâche spécifiée n\'existe pas.');
        }
    }






    // public function updateStatus($taskId)
    // {
    //     $task = Task::findOrFail($taskId);

    //     // Mettre à jour le statut en "commencer" si le statut actuel est différent
    //     $task->status = 'En cours';

    //     // Enregistrer les modifications
    //     $task->save();

    //     return redirect()->back()->with('success', 'vous avez debuter votre tache');
    // }




    // // Pour le bouton marquer comme terminer
    // public function updatedStatus($taskId)
    // {
    //     $task = Task::findOrFail($taskId);

    //     // Mettre à jour le statut en "Terminer" si le statut actuel est différent
    //     $task->status = 'Terminer';

    //     // Enregistrer les modifications
    //     $task->save();

    //     return redirect()->back()->with('success', "Merci d'avoir terminé votre tâche");
    // }







}
