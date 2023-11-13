<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JuryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user = [];

    // public $url="http://127.0.0.1:8000/noteEtudiant/";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $users)
    {
        // $this->url .= $urls;

        $this->user = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ecole Doctorale')
                    ->markdown('ecoleDoctorat.email.juryMail');

    }
}
// ->attachFromStorage('public/'.$this->user['patch_mem'])
