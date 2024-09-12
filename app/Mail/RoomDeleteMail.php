<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $room;

    public function __construct($room)
    {
        $this->room = $room;
    }

    public function build()
    {
        return $this->markdown('mail.room_delete')->subject('Room '. $this->room->title_en.' deleted' );
    }

}