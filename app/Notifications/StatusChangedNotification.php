<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatusChangedNotification extends Notification
{
    use Queueable;

    public $advertStatus;
    public $advertTitle;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status, $title)
    {
        $this->advertStatus = $status;
        $this->advertTitle = $title;
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'nexmo'];
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
                    ->line('The status of ' . $this->advertTitle)
                    ->line(' is ' . $this->advertStatus . ' now.')
                    ->action('Watch it!', route('cabinet.adverts.home'))
                    ->line('Thank you for using our application!');
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
                    ->content('The status of' . $this->advertTitle . 'is ' . $this->advertStatus . ' now.')
                    ->unicode();
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
