<?php
@include "config.php";
use App\Models\User;

$usuario = User::where('level', '=', 'admin')->count();

if($usuario == 0){
    
    $tabela  = new User();

    $tabela->name       = 'Administrador';
    $tabela->cpf        = '000.000.000-00';
    $tabela->user       = $email_adm;
    $tabela->password   = '123';
    $tabela->level      = 'admin';

    $tabela->save();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Custom styles for this template-->
	<link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="{{ URL::asset('css/style.css')}}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{ URL::asset('img/favicon.ico')}}" type="image/x-icon">

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Faça seu Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Nunito');
        @import url('https://fonts.googleapis.com/css?family=Poiret+One');

        body, html {
            height: 100%;
            background-repeat: no-repeat;    /*background-image: linear-gradient(rgb(12, 97, 33),rgb(104, 145, 162));*/
            background:black;
            position: relative;
        }
        #login-box {
            position: absolute;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
            width: 350px;
            margin: 0 auto;
            border: 1px solid black;
            background: rgba(48, 46, 45, 1);
            min-height: 250px;
            padding: 20px;
            z-index: 9999;
        }
        #login-box .logo .logo-caption {
            font-family: 'Poiret One', cursive;
            color: white;
            text-align: center;
            margin-bottom: 0px;
        }
        #login-box .logo .tweak {
            color: #ff5252;
        }
        #login-box .controls {
            padding-top: 30px;
        }
        #login-box .controls input {
            border-radius: 0px;
            background: rgb(98, 96, 96);
            border: 0px;
            color: white;
            font-family: 'Nunito', sans-serif;
        }
        #login-box .controls input:focus {
            box-shadow: none;
        }
        #login-box .controls input:first-child {
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
        }
        #login-box .controls input:last-child {
            border-bottom-left-radius: 2px;
            border-bottom-right-radius: 2px;
        }
        #login-box button.btn-custom {
            border-radius: 2px;
            margin-top: 8px;
            background:#ff5252;
            border-color: rgba(48, 46, 45, 1);
            color: white;
            font-family: 'Nunito', sans-serif;
        }
        #login-box button.btn-custom:hover{
            -webkit-transition: all 500ms ease;
            -moz-transition: all 500ms ease;
            -ms-transition: all 500ms ease;
            -o-transition: all 500ms ease;
            transition: all 500ms ease;
            background: rgba(48, 46, 45, 1);
            border-color: #ff5252;
        }
        #particles-js{
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: 50% 50%;
            position: fixed;
            top: 0px;
            z-index:1;
        }

        .recuperar {
			font-size: 12px;
			color: #e3e6e4;
			margin-top: 10px;
		}

		.recuperar:hover {
			color: #d4d4d4;
		}

        .modalrecuperar{
            z-index: 100000;
            position: fixed;
        }
    </style>
    <script>
        $.getScript("https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js", function(){
            particlesJS('particles-js',
            {
                "particles": {
                "number": {
                    "value": 80,
                    "density": {
                    "enable": true,
                    "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                    "width": 0,
                    "color": "#000000"
                    },
                    "polygon": {
                    "nb_sides": 5
                    },
                    "image": {
                    "width": 100,
                    "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                    }
                },
                "size": {
                    "value": 5,
                    "random": true,
                    "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                    }
                }
                },
                "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                    "enable": true,
                    "mode": "repulse"
                    },
                    "onclick": {
                    "enable": true,
                    "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                    },
                    "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                    },
                    "repulse": {
                    "distance": 200
                    },
                    "push": {
                    "particles_nb": 4
                    },
                    "remove": {
                    "particles_nb": 2
                    }
                }
                },
                "retina_detect": true,
                "config_demo": {
                "hide_card": false,
                "background_color": "#b61924",
                "background_image": "",
                "background_position": "50% 50%",
                "background_repeat": "no-repeat",
                "background_size": "cover"
                }
            }
            );

        });

    </script>
    
 <script type="text/javascript">  
    function showModal(){
    $('#recuperar').modal('show');
    $(".modal-backdrop.in").hide();
    }
    $(window).load(function(){
            showModal();
        });

</script>
</head>
<body>
    <div class="container">
        <div id="login-box">
            <div class="logo">
                <img src="{{ URL::asset('img/logo_barber.png')}}" class="img img-responsive img-circle center-block"style="width: 150px"/>
                <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
            </div><!-- /.logo -->
            <div class="controls">
                <form action="{{route('login')}}" method="post">
                    @csrf
                    <input name="user" type="text" placeholder="Usuário" class="form-control" required="required">
                    <input name="password" type="password" placeholder="senha" class="form-control" required="required">
                    <button class="btn btn-default btn-block btn-custom" type="submit">ENTRAR</button>
                    <div align="center" class="recuperar"><a href="" class="recuperar" data-toggle="modal" data-target="#recuperar">Recuperar Senha?</a></div>
                </form>
            </div><!-- /.controls -->
 
        </div><!-- /#login-box -->
        
    </div><!-- /.container -->
    <div id="particles-js"></div>

<div class="modalrecuperar">
                                    
    <!-- Modal Recuperar -->
    <div class="modal  fade" id="recuperar" tabindex="-1" aria-labelledby="exampleModalLabel" role='dialog' data-backdrop="false" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content show">
    
                <div class="modal-header">
    
                    <h5 class="modal-title"><small>Recupere a sua Senha</small></h5>
    
                    <button type="submit" class="close" name="fecharModal">&times;</button>
    
                </div>
    
                <div class="modal-body ">
                    <form method="POST" action="">
                    @csrf
                        <div class="row">
    
                            <div class="form-group col-md-8 col-lg-8 col-sm-12">
                                <label for="id_produto">Digite seu Email</label>
                                <input type="email" class="form-control mr-2" name="email" placeholder="Email" required>
                                <input value="{{$email_adm}}" type="hidden" name="email_adm">
                            </div>
                            <label for="id_produto"></label>
                            <div class="col-md-4 col-lg-4 col-sm-12 mt-4">
                                <button type="submit" class="btn btn-primary mt-2" name="recuperar">Recuperar </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
</body>
</html>

 <!-- Bootstrap core JavaScript-->
 <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
 <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>