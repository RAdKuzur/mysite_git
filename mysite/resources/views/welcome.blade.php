<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <title>Главная</title>
</head>
<body>
    <div align="center"> Вход в учётную запись произведён успешно </div>
    <div class="data-profile">
        <h1> Данные пользователя </h1>
        @foreach ($record = Session::get('record') as $el)
        <h5>email:    {{$el->email}}</h5>
        <h5>name:    {{$el->name}}</h5>
        @endforeach
    </div>
</body>
</html>