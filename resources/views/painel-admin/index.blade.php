@extends('template.template-admin')
@section('title', 'Administrador')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'admin'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
use App\Models\ContasPagares;
use App\Models\Movimentacao;
use App\Models\Atendente;
use App\Models\Agenda;
use App\Models\Comissoe;
use App\Models\Cliente;
use App\Models\Service;
use App\Models\Solicitacao;

//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$totalContasVencidas = ContasPagares::where('data_venc', '<', $hoje)->where('status', '!=', 'Pago')->count();
$totalCliente = Cliente::count();
$totalAtendente = Atendente::count();
$totalServicos = Service::count();
$totalAgenda = Agenda::where('data', '>=', $dataInicioMes)->where('data', '<=', $hoje)->count();
$totalAgendaPendente = Agenda::where('status_baixa', '=', 0)->count();
$solicitacoes = Solicitacao::where('status', '=', 0)->count();
$solicitacoes1 = Solicitacao::where('status', '=', 1)->count();



//TOTALIZAR ENTRADAS e SAÍDAS DO DIA
$entradas = 0;
$saidas = 0;
$saldo = 0;
$data_atual = date('Y-m-d');
$tabela = Movimentacao::where('data', '=', $hoje)->get();
foreach ($tabela as $tab) {
  if ($tab->tipo == 'Entrada') {
    $entradas = $entradas + $tab->value;
  } else {
    $saidas = $saidas + $tab->value;
  }
}
$saldo = $entradas - $saidas;

if($saldo < 0){
  $classe = 'text-danger';
  $classe2 = 'border-left-danger';
}else{
  $classe = 'text-success';
  $classe2 = 'border-left-success';
}

$entradas = number_format($entradas, 2, ',', '.');
$saidas = number_format($saidas, 2, ',', '.');
$saldo = number_format($saldo, 2, ',', '.');


//TOTALIZAR ENTRADAS e SAÍDAS DO MES
$entradasMes = 0;
$saidasMes = 0;
$saldoMes = 0;


$tabela = Movimentacao::where('data', '>=', $dataInicioMes)->where('data', '<=', $hoje)->get();
foreach ($tabela as $tab) {
  if ($tab->tipo == 'Entrada') {
    $entradasMes = $entradasMes + $tab->value;
  } else {
    $saidasMes = $saidasMes + $tab->value;
  }
}
$saldoMes = $entradasMes - $saidasMes;

if($saldoMes < 0){
  $classeMes = 'text-danger';
  $classe2Mes = 'border-left-danger';
}else{
  $classeMes = 'text-success';
  $classe2Mes = 'border-left-success';
}

$entradasMes = number_format($entradasMes, 2, ',', '.');
$saidasMes = number_format($saidasMes, 2, ',', '.');
$saldoMes = number_format($saldoMes, 2, ',', '.');


?>

<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Clientes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCliente ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Atendentes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAtendente ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classe}} text-uppercase mb-1">Agendados</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo @$totalAgendaPendente ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x {{$classe}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Agendas no Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalAgenda ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Contas Vencidas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$totalContasVencidas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Dia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$entradas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saídas do dia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saidas ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classe}} text-uppercase mb-1">Saldo Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldo ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x {{$classe}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tipos Serviços</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo @$totalServicos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-code-branch fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$entradasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saídas Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saidasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card {{$classe2Mes}} shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{$classeMes}} text-uppercase mb-1">Saldo Total Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$saldoMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x {{$classeMes}}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
<!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary  shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-primary text-uppercase mb-1">Novas Solicitações</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$solicitacoes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sync fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-primary text-uppercase mb-1">Total de solicitações Finalizadas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$solicitacoes1?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sync fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection