<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class POMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'posignedrequest'){
            return $this->subject('Keperluan Upload Tanda tangan Basah')
                        ->view('mail.posignedrequest')
                        ->attachFromStorageDisk('public',$this->data['po']->internal_signed_filepath);
        }
        if($this->type == 'posignedreject'){
            return $this->subject('Penolakan Upload Tanda tangan Basah')
                        ->view('mail.posignedreject');
        }
    }
}
