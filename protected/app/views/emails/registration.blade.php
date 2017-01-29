<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hello {{ $firstname }} , </h2>
		<p> Thank your for joining with our site </p>
		<p> Bellow is your account Info </p>
		<p>
			Email : {{ $email }} <br />
			Password : {{ $password }}<br />
		</p>
		
		<p> Thank You </p><br /><br />
		
		{{ CNF_APPNAME }} 
	</body>
</html>