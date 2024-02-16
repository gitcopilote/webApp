<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistrationNotification extends Notification
{
    use Queueable;

    protected $pendingUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

            'name' => $this->pendingUser->name,
            'message' => "Vous avez une nouvelle demande d'adhésion de",
            'email' => $this->pendingUser->email,
            'action_url' => url('/approve-registration/' . $this->pendingUser->id),
        ];
    }
}
