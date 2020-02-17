<?php
namespace GD\Api\Events;
use Illuminate\Queue\SerializesModels;

class SendMailActiveEvent
{
    use SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}