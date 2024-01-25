<?php

namespace App\Notifications;

use App\Mail\HamkkeMailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomerWelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $fingerHeartGif = asset('images/finger-heart-gif.gif');
        return (new MailMessage)
            ->subject('Onionhaseyo! 🥰')
            ->greeting('Annyeong Chingu,')
            ->line('Welcome to the best community ever!')
            ->line('You probably already sort of met us through the website, but being here means you’re now a registered member of our community, and we love it for you!')
            ->line(new HtmlString("<img src='{$fingerHeartGif}' alt='finger heart gif'/>"))
            ->line('We have one goal, and that’s to make your Korean enthusiast journey the easiest and most fun experience. From Korean language lessons to exposes on your favourite celebs, interesting history facts and a community of like-minded enthusiasts like yourself, we’ve got it all for you!')
            ->line('Stick with us, it’s about to get more exciting. In the meantime, here’s a gift from us to you. We promise you’ll love it!')
            ->line('Let’s Stay Hamkke! 💜')
            ->action('Claim my gift', url('/'))
            ->salutation(new HtmlString("<span style='font-family: Pacifico,serif'>Dara</span>"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
