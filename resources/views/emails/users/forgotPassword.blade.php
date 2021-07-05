<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Ấn vào đường link sau để thay đổi mật khẩu!
    Link:<a href="{{$mail['url']}}/reset-password?email={{$mail['email']}}&token={{$mail['token']}}" target="_blank">Click vào đây</a>
</body>

</html>