<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" type="text/css" href="../css/main.css">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
   
    <title>Вход</title>
</head>
<body>
    <div class = "text-1"><h1>Добро пожаловать!!!</h1></div>
    <div class = "text-2"><h2>Для начала введите свои логин и пароль</h2></div>
    <div class = "container">
        <div class = "form-1">
            @auth
                {{auth()->user()->name}}
            @endauth
            <div class = "mt-t"> 
                @if ($errors -> any())
                    <div class = "col-12">
                        @foreach ($errors->all() as $error)
                            <div class = "alert alert-danger">{{$error}}</div>
                            
                        @endforeach
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class = "alert alert-danger">{{session('error')}}</div>
                @endif
                @if (session()->has('success'))
                    <div class = "alert alert-success">{{session('success')}}</div>
    
                @endif
            <form action = "{{route('login.post')}}" method="POST">
                @csrf 
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control"  placeholder="Enter email" name = "email">
                  <!--  <small id="emailHelp" class="form-text text-muted"></small> -->
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name = "password">
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