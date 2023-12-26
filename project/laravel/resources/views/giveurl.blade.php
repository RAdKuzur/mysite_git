<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel = "stylesheet" type="text/css" href="../css/main-style.css">
    <script src = "../js/movemouse.js">   </script> 
    
    <title>Раздача ссылок</title>
</head>
<body class = "body-2">
<div id="highlight"></div>                                                         
    <div class = "img">
        <img src = "/img/olymp.png" class = "img-olymp">
        <img src = "/img/gerb.png" class = "img-gerb">
        <h3 class = "text-1"> </br>Астраханская</br>область</h3>    
    </div>
    <div class = "container box-1" id = "mySchool">
      @php
      $record = $record['data']
      @endphp
    <form action="{{route('giveurl')}}" method = "POST"> 
        @csrf 
        <div>Название школы:</br><input type="text" style="width:70%" name="name" list="productName"></div>
        <datalist id="productName">
            
            @for ($i = 0; $i < $num2; $i++)
                <option value = "{{$record[$i]['name']}}">{{$record[$i]['id']}}</option>
            @endfor
        </datalist> 
            </br>
        <div>Фамилия:</br><input type="text" style="width:70%" name="surname_teacher"></div>
            </br>
        <div>Имя:</br> <input type="text" style="width:70%" name="name_teacher"></div>
            </br>
        <button type="button submit" class="btn btn-primary button-2" id = "button-2">Выбрать школу
        <script src = "../js/options.js">   </script> 
        </button>
    </form>
    </div>
</body>
</html>
