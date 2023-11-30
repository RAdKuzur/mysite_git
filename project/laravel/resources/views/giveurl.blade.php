<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <title>Раздача ссылок</title>
</head>
<body>
@csrf
    <div align="center">Раздача ссылок</div>
    <div class="data-profile">
        <h1> Ссылки </h1>
        <div>URL учителя 1: {{$url}}</h2>
        <div>URL учителя 2: {{$url2}}</h2>
        <div>URL учителя 3: {{$url3}}</h2>
    </div>
</body>
</html>