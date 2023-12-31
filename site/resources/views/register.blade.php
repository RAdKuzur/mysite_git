<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="../css/register.css">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>
</head>
<body>
    <div class = "text-1"><h1>Окно регистрации</h1></div>
    <div class = "container">
        <div class = "form-1">
            <form action="/main" method = "POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Your Name</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
                    <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Your nickname</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Nickname">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div> 
                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-danger" type="submit">Зарегистрироваться</button>
                </div>
            </form>
       
        </div>
    </div>
    <div class = "bottom-1"> 
    </div>
</body>
</html>