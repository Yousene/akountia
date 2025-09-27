<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class remboursementEmail extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

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
            ->subject('Remboursement '.Carbon::now()->format('Y-m-d'))
            ->greeting('Bonjour M/Mme,')
            ->line('Nous avons de plaisir de vous annoncer que de nouvelles expéditions ont été remboursées.')
            ->line(new HtmlString("<p>Priére de trouver le détail de vos remboursements en suivant <a href='".URL::to('/remboursement/list')."'>le lien ci-dessous.</a></p>"))
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
