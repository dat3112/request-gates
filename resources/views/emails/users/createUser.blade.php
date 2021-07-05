<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Tài khoản REQUEST GATE của bạn đã được khởi tạo.<br>
    Tên đăng nhập: {{$mail['email']}} <br>
    Mật khẩu: <p><strong>{{$mail['password']}}</strong></p><br>
    Đăng nhập <a href="{{$mail['url']}}/login">Link</a> để thay đổi mật khẩu.
</body>

</html>