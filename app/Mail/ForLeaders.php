<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForLeaders extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $url;
    /**
     * @var
     */
    public $data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $data, $url)
    {
        $this->user = $user;
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
                    ->from($this->data->from)
                    ->subject($this->data->subject)
                    ->view('emails.' . $this->data->view);
    }
}
