<form method="post" action="{{ route('generate2faSecret') }}">
	@csrf
	<h3>Google 2FA</h3>
	<button>Generate</button>
</form>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Set up Google Authenticator</div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($data['user']->passwordSecurity->google2fa_enable == 0)
					<form action="{{ route('enable2fa') }}" method="post">
					@csrf
                    <div class="panel-body" style="text-align: center;">
                        <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code </p>
                        <div>
                            <img src="{{ $data['google2fa_url'] }}">
                        </div>
                        <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                        <div>
                        	Authenticator Code: <input type="text" name="verify-code"><br><br>
                            <button class="btn-primary">Enable 2FA</button>
                        </div><br>
                    </div>
                	</form>
                	@else
                	<form action="{{ route('disable2fa') }}" method="post">
					@csrf
                    <div class="panel-body" style="text-align: center;">
                        <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code </p>
                        <div>
                        	Current Password: <input type="password" name="current-password"><br><br>
                            <button class="btn-primary">Disable 2FA</button>
                        </div>
                    </div>
                	</form>
                	@endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>