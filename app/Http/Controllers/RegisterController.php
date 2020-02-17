<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use App\User;
use Auth;

class RegisterController extends Controller
{
	public function register(Request $request)
	{
	    //Validate the incoming request using the already included validator method
	    //$this->validator($request->all())->validate();

	    // Initialise the 2FA class
	    $google2fa = app('pragmarx.google2fa');

	    // Save the registration data in an array
	    $registrationData = $request->all();

	    // Add the secret key to the registration data
	    $registrationData['google2fa_secret'] = $google2fa->generateSecretKey();

	    // Save the registration data to the user session for just the next request
	    $request->session()->flash('registration_data', $registrationData);
	    // Generate the QR image. This is the image the user will scan with their app
	    // to set up two factor authentication
	    $qrImage = $google2fa->getQRCodeGoogleUrl(
	        config('app.name'),
	        $registrationData['email'],
	        $registrationData['google2fa_secret']
	    );

	    // Pass the QR barcode image to our view
	    return view('google2fa.register', ['secret' => $registrationData['google2fa_secret']]);
	}
}