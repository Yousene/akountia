<?php

namespace App\Notifications;

//use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistredUser extends Notification
{
    //use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Validation de votre compte.')
            ->line("Bonjour {$notifiable->name} {$notifiable->first_name}")
            ->line("Nous vous souhaitons la bienvenue dans notre réseau GO TAWSIL.")
            ->line("Votre inscription vous permet d accéder à votre espace et de suivre ainsi vos expéditions.")
            ->line("Pour activer votre compte ,veuillez cliquer sur le lien ci-dessous :")
            ->action('Lien de confirmation', url("confirm/{$notifiable->id}/{$notifiable->confirmation_token}"))
            ->line("Cordialement,")
            ->line("Service client GO TAWSIL");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
