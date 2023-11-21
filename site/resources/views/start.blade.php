<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="../css/main.css">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>
</head>
<body>
    <div class = "text-1"><h1>Добро пожаловать!!!</h1></div>
    <div class = "text-2"><h2>Для начала введите свои логин и пароль</h2></div>
    <div class = "container">
        <div class = "form-1">
            <form action = "/main" method="POST">
                @csrf 
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div> 
              
                <button class="btn btn-success" type="submit">Войти</button>
                <a href="/register" class = "btn btn-danger">Зарегистрироваться</a>
            </form>
           
        </div>
    </div>
    <div class = "bottom-1"> 
    </div>
</body>
</html>