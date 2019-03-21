<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form action="/login" method="post">
        {{csrf_field()}}
       用户名： <input type="text" name="u_name"><br>
       密码 ： <input type="password" name="u_pass"><br>
        <input type="hidden" name="redirect" value="{{$redirect}}">
        <input type="submit">
    </form>
</body>
</html>