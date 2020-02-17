<?php
namespace GD\Api\Listeners;
use GD\Api\Events\SendMailActiveEvent;
use GD\Api\Mail\ActiveUserMail;
use Mail;
use DB;
class SendMailActiveListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct(){
    }

    /**
     * Handle the event.
     *
     * @param  \TTSoft\Api\Events\SendMailActiveEvent  $event
     * @return void
     */
    public function handle(SendMailActiveEvent $event)
    {
        $user  = $event->data;
        $token = str_replace('-', '', (string) \Str::uuid());
        $user->activeAccount($token);
        $data = [
            'token'     => $token,
            'email'     => $user->email,
            'fullName'  => $user->getFullName(),
            'urlActive' => env('CUSTOMER_LINK_ACTIVE')
        ];
        if (env('QUEUE_CONNECTION') == 'database') {
            Mail::to($user->email)->queue(new ActiveUserMail($data));
        }else{
            Mail::to($user->email)->send(new ActiveUserMail($data));
        }
    }
}
