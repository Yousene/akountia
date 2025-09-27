<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class forgetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $token;

   public function __construct($tokens)
   {

       $this->token = $tokens ;


   }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)

                    ->subject('Réinitialisation de votre mot de passe GoTawsil')
                    ->greeting('Bonjour M/Mme,')
                    ->line('Suite á votre demande de réinitialisation de votre mot de passe de votre compte, nous vous invitons á cliquer sur le lien ci-dessous pour pouvoir le réinitialiser.')
                    ->action('Réinitialiser votre mot de passe', url('/reset-password/'.$this->token))
                    ->salutation('Cordialement,')
                    ->line("Service client GO TAWSIL");
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
            //
        ];
    }
}
