<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // public $tries = 3;

    /**
     * The order instance.
     *
     * @var \App\Models\User
     */
    protected $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@likdom.ma', 'Likdom')
            ->subject('Bienvenu chez Likdom')
            ->markdown('emails.welcome_email', [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
            ]);
    }
}
