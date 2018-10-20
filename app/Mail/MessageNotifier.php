<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
class MessageNotifier extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $message;

    public function __construct($fromId, $message)
    {
        $user = User::find($fromId);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->email, $this->name)
            ->subject("New message from Adverts" . "(" . $this->name . ")")
            ->markdown('emails.messages');
    }
}
