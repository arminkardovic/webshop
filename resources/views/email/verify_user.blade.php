<!DOCTYPE html>
<html>
<head>
    <title>Welcome to SOSA shop platform!</title>
</head>

<body>
<h2>Hello {{$user->first_name . ' ' . $user->last_name}}</h2>
<br/>
Your registered email is {{$user->email}} , Please click on the below link to verify your email account
<br/>
<a href="{{url('user/verify/' . $user->activation_code)}}">Verify Email</a>
</body>

</html>