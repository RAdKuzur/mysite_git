<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type="text/css" href="../css/main-style.css">
    <link rel = "stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="shortcut icon" href="/img/flag.png" type="image/png"> 
    <title>Страница подтверждения</title>
</head>
<body class = "body-1">

    <div class = "img">
        <img src = "/img/olymp.png" class = "img-olymp">
        <img src = "/img/gerb.png" class = "img-gerb">
        <h3 class = "text-1"> </br>Астраханская</br>область</h3>    
    </div>
    <div class="container box-1" id = "table-1"> 
        <form action="{{route('register.post', $id_teacher)}}" method = "POST">  
            @csrf
            <h2>Ваш класс:</h2>
            <table class="table table-bordered"  id="myTable">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Почта участника</th>
                    <th scope="col">Статус участника</th>
                </tr>
                </thead>
                <tbody>
                {{$number = 1}}
                @foreach ($record as $element) 
                <tr>
                    <th scope="row">{{$number}}</th>
                        <td>{{$element->name}}</td>
                        <td>{{$element->surname}}</td>
                        <td>{{$element->email}}</td>
                        @if($element->flag)
                        <td><input type="checkbox" class="form-check-input" checked><label></label></td>
                        @else
                        <td><input type="checkbox" class="form-check-input" unchecked><label></label></td>
                        @endif
                    </tr>
                    {{$number = $number + 1}}
                    @endforeach
                </tbody>
            </table>
            <script>
                var table = document.getElementById("myTable");
                var checkboxes = table.getElementsByTagName("input");
                for (var i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].id = "checkbox" + (i + 1);
                    checkboxes[i].name = "checkbox" + (i + 1);
                }
            </script>
            <button type="button submit" class="btn btn-primary button-1" id = "button-1">
                <script src="../js/script.js"></script>
                Подтвердить участие
            </button>
        </form>
    </div>   
    <div class="container box-1" id = "div-1">Ваше участие подтверждено</div> 
    </div>   
</body>
</html>