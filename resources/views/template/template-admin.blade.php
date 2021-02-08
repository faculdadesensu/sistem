<?php

use App\Models\Usuario;
use App\Models\Atendente;
use App\Models\Recepcionista;

@session_start();
$id_usuario = @$_SESSION['id_user'];
$usuario = DB::select('select * from users where id ='.$id_usuario);
$hoje = date('Y-m-d');

@include "config.php";
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Faculdade SENSU">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->

    <link href="{{ URL::asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ URL::asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar accordion" style="color:#663610; background:#D9D9D9;"id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" style="color:#663610" href="{{ route('admin.index') }}">
                <div class="sidebar-brand-text mx-3">Administrador</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Cadastros
            </div>
            <li class="nav-item" style="color:#663610">
                <a class="nav-link collapsed" style="color:#663610" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-users"></i>
                    <span> Cadastro Pessoas</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('cadAtend')}}">Atendentes</a>
                        <a class="collapse-item" href="{{route('recep.index')}}">Recepcionistas</a>
                        <a class="collapse-item" href="{{route('users.index')}}">Usuários</a>
                        <a class="collapse-item" href="{{route('clientes.index')}}">Clientes</a>
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" style="color:#663610" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-code-branch"></i>
                    <span>Cadastro Serviço</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('service.index')}}">Serviços</a>
                        <a class="collapse-item" href="{{route('hora.index')}}">Horários</a>

                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                rotinas
            </div>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" style="color:#663610" href="{{route('agendas.index')}}">
                    <i class="fas fa-calendar-alt fa-chart"></i>
                    <span>Agenda</span>
                </a>
            </li>
             <!-- Divider -->
             <hr class="sidebar-divider my-0">
             <!-- Divider -->
             <hr class="sidebar-divider">
             <!-- Heading -->
             <div class="sidebar-heading">
                 CAIXA
             </div>
         <li class="nav-item">
             <a class="nav-link collapsed" style="color:#663610"  href="#" data-toggle="collapse" data-target="#collapseUtilities3" aria-expanded="true" aria-controls="collapseUtilities">
                 <i class="fas fa-donate"></i>
                 <span>Financeiro</span>
             </a>
             <div id="collapseUtilities3" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">                            
                     <a class="collapse-item" href="{{route('administrador.pagar.index')}}">Contas a Pagar</a>
                     <a class="collapse-item" href="{{route('administrador.contas-receber.index')}}">Contas a Receber</a>
                     <a class="collapse-item" href="{{route('administrador.movimentacao.index')}}">Movimentação</a>
                 </div>
             </div>
         </li>  
         <hr class="sidebar-divider">      
             <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" style="color:#663610" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-scroll"></i>
                    <span>Relatórios</span>
                </a>
                <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="" data-toggle="modal" data-target="#relRel">Comissões</a>
                        <a class="collapse-item" href="" data-toggle="modal" data-target="#relMov">Movimentaçôes</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="mt-4 mb-2" style="color:#663610" >
                        <h5>{{$nome_estabelecimento}}</h5>
                        <h6>{{$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')))}} - {{$endereco}}</h6>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$usuario[0]->name}}</span>
                                <img class="img-profile rounded-circle" src="{{ URL::asset('img/default.jpg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#ModalPerfil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-primary"></i>
                                    Editar Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('user.logout')}}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger"></i>
                                    Sair
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!--  Modal Perfil-->
    <div class="modal fade" id="ModalPerfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Perfil</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="form-perfil" method="POST" action="{{ route('admin.edit', $id_usuario) }}">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome</label>
                            <input value="{{$usuario[0]->name}}" type="text" class="form-control" id="name" name="name" placeholder="Nome">
                        </div>

                        <div class="form-group">
                            <label>CPF</label>
                            <input value="{{$usuario[0]->cpf}}" type="text" class="form-control cpf" id="cpf" name="cpf" placeholder="E-mail">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input value="{{$usuario[0]->user}}" type="email" class="form-control" id="user" name="user" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label>Senha</label>
                            <input value="{{$usuario[0]->password}}" type="password" class="form-control" id="senha" name="password" placeholder="Senha">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-fechar" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="btn-salvar-perfil" id="btn-salvar-perfil" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Rel Comissão-->
    <div class="modal fade " id="relRel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecionar Datas - Atendente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form method="GET" action="{{route('admin-comissao.index')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i>Data Inicio</i></h6>
                                <input value="{{$hoje}}" class="form-control" name="dataInicial" type="date">
                            </div>
                            <div class="col-md-6">
                                <h6><i>Data Fim</i></h6>
                                <input value="{{$hoje}}" class="form-control " name="dataFinal" type="date">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 mt-4">
                                <h6><i>Atendente</i></h6>
                                <select class="form-control" name="atendente" required>
                                    <option selected>Selecione um atendente</option>
                                    <?php $atendente = Atendente::orderby('id', 'desc')->get() ?>
                                    @foreach ($atendente as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rel Comissão-->
    <div class="modal fade " id="relMov" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecionar Datas - Movimentaçôes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <form method="GET" action="{{route('admin-movimentacao.index')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i>Data Inicio</i></h6>
                                <input value="{{$hoje}}" class="form-control" name="dataInicial" type="date">
                            </div>
                            <div class="col-md-6">
                                <h6><i>Data Fim</i></h6>
                                <input value="{{$hoje}}" class="form-control " name="dataFinal" type="date">
                            </div>
                        </div>
                        <div class="row mt-4 mb-4">
                            <div class="col-md-6">
                                <h6><i>Recepcionista</i></h6>
                                <select class="form-control" name="recepcionista" required>
                                    <option value="todos2">Todos</option>
                                    <?php $recepcionista = Recepcionista::orderby('id', 'desc')->get() ?>
                                    @foreach ($recepcionista as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 ">
                                <h6 class=""><i>Tipo</i></h6>
                                <select class="form-control" name="status">
                                    <option value="todos">Todos</option>
                                    <option value="Saida">Saida</option>
                                    <option value="Entrada">Entrada</option>
                                </select>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ URL::asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ URL::asset('js/demo/chart-pie-demo.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ URL::asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ URL::asset('js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('js/mascaras.js') }}"></script>
</body>
</html>