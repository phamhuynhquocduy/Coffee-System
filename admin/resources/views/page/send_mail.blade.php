<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send mail from Google</title>
</head>
<body>
    <h1>Mail được gửi từ: {{ $name }}</h1>
    <h4>Với nội dung: {{ $body }}</h4>
    <p>Link reset mật khẩu: <a href="{{ route('get-reset-admin' ,$token) }}">Link</a></p>
</body>
</html>