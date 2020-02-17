<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    //
    public function sendEmail(){
    	$details['email'] = 'vucongtruong1998@gmail.com';
    	dispatch(new \App\Jobs\SendEmailJob($details));
    	
    }
}
