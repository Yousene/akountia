<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class noLivreeExpedition extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     protected $num_expedition;
     protected $commentaire;

    public function __construct($num_expedition,$commentaire)
    {

        $this->num_expedition = $num_expedition ;
        $this->commentaire = $commentaire;

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
                    ->subject('Avis de souffrance du colis  N°: '.$this->num_expedition)
                    ->greeting('Bonjour M/Mme,')
                    ->line("Nous vous informons que le colis ".$this->num_expedition." n'est pas livré cause du motif suivant: ")
                    ->line(''.$this->commentaire.'')
                    ->line('Priére de prendre contact avec votre client pour augmenter les chances de livraison lors des prochaines tentatives.')
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
