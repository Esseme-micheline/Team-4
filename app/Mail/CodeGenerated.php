<?php
namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $option;
    public $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code,$option,$file)
    {
        $this->code = $code;
        $this->option = $option;
        $this->attachment = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->option == "rejected"){
            return $this->subject('Your Project has been denied due to reasons')
            ->view('email.document_denied')
            ->attachData($this->attachment->output(),'Review Form.pdf')
            ->with('code', $this->code);
        }
        else if($this->option == "validated")
        {
            return $this->subject('Your document and files have been accepted')
            ->view('email.code_generated')
            ->attachData($this->attachment->output(),'Review Form.pdf');
        }
    }
}
