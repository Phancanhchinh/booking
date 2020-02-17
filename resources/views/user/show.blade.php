<!DOCTYPE html>
<html>
<head>
	<title>Repositories</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" crossorigin="anonymous">
</head>
<body>
	<h3>Hello User: <span class="label label-info">{{$user->name}}</span></h3>
	<div class="form-group">
		<label>Id: {{$user->id}}</label><br>
		<label>Email: {{$user->email}}</label><br>
		@foreach($user->roles as $value)		
		<label>Roles: <span class="label label-success">{{$value->display_name}}<span>
		</label>
		@endforeach

	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>