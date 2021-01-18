<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{ URL::asset('img/favicon.ico')}}" type="image/x-icon">

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <title>Faça seu Login</title>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <div class="avatar">
                <img class="img-login" src="{{ URL::asset('img/favicon.ico')}}">
            </div>
            <div class="form-box">
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <input name="user" type="text" placeholder="Usuário" required="required">
                    <input name="password" type="password" placeholder="senha" required="required">
                    <button class="btn btn-info btn-block login" type="submit">ENTRAR</button>
                </form>
            </div>
        </div>        
    </div>
</body>
</html>