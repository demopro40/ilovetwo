<!DOCTYPE html>
<html lang="en">
<head>
	<title>愛樂Two排約</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="csrf_timeout_in_seconds">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel = "icon" type = "image/png" href = "name-of-image.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<style>
		body{
			background-color:#2b2b2b;
			color:#c3a367;
		}
	</style>
</head>
<body>
@php
    $maintain = false;
	$w = date('w',time());
    $H = date('H',time());
	if( $w == 5 && $H <= 19 ){
		$maintain = true;
	}
@endphp
<br><br>
@if($data['test'])
<h1 class="text-center" style="margin-top:7%">網站維護中</h1>
<footer class="text-center" style="margin-top:30%">
	Copyright © 2022 Luke Rights Reserved.
</footer>
@else
<div class="container" style="max-width:332px;">
	<h2 class="text-center"><strong>愛樂Two會員登入</strong></h2>
	<br>
	@if(Session::has('error_msg'))
		<div class="alert alert-danger">{{Session::get('error_msg')}}</div>
	@endif
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<form action="/date/login_post" method="post" id="login_form">
		@csrf
		<div class="form-group">
		  <label for="account">帳號:</label>
		  <input type="text" class="form-control" id="account" placeholder="輸入帳號" name="account" value="{{old('account')}}" required>
		</div>
		<div class="form-group">
		  <label for="password">密碼:</label>
		  <input type="password" class="form-control" id="password" placeholder="輸入密碼" name="password" value="{{old('password')}}" required>
		</div>
		<div class="g-recaptcha" data-sitekey="6LcucHghAAAAACxfLrRUDkRhEH6gUclGOBguFemq" style="margin-top:25px;"></div>
		<br>
		<div class="text-center">
			<button class="btn btn-primary" 
			style="width:100px;background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">登入</button>
		</div>
	</form>
</div>

<footer class="text-center" style="margin-top:20%">
	Copyright © 2022 Luke Rights Reserved.
</footer>
@endif

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("login_form").submit();
   }
 </script>
@include('date.components.footer')
