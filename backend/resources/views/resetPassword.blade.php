<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Password Reset</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #F2F2F2;
			font-family: Arial, sans-serif;
			font-size: 14px;
		}

		.container {
			max-width: 600px;
			margin: 0 auto;
			padding: 20px;
			background-color: #FFFFFF;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
			border-radius: 5px;
			text-align: center;
		}

		h1 {
			font-size: 24px;
			margin-bottom: 20px;
			color: #333333;
		}

		p {
			margin: 0 0 20px 0;
			color: #555555;
		}

		a {
			display: inline-block;
			margin: 20px 0;
			padding: 10px 20px;
			background-color: teal;
			color: #FFFFFF;
			text-decoration: none;
			border-radius: 5px;
			transition: background-color 0.2s;
		}

		.footer {
			margin-top: 20px;
			padding-top: 20px;
			border-top: 1px solid #DDDDDD;
			color: #AAAAAA;
		}
		span{
			color:white;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Password Reset</h1>
		<p>You are receiving this email because we received a password reset request for your account.</p>
		<a href="{{ config('app.admin_url') }}/{{$token}}"><span>Reset Password</span></a>
		<p>If you did not request a password reset, no further action is required.</p>
		<div class="footer">
			<p>This email was sent from our website.</p>
		</div>
	</div>
</body>
</html>