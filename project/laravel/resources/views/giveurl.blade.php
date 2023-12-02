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
        @for ($i = 0; $i < $num; $i++)
            <div>URL учителя: {{$url[$i]}}</div>
        @endfor
    </div>
</body>
</html>
