<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\HistoricalNotification;

use App\Models\User;

class SendAdminNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-admin-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly notifications to admin users';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Récupérer les utilisateurs avec le rôle administrateur
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'administrateur');
        })->get();

        // Envoyer la notification à chaque utilisateur administrateur
        foreach ($adminUsers as $admin) {
            $admin->notify(new HistoricalNotification($admin));
        }

        $this->info('Notifications sent to admin users.');
    }
}
