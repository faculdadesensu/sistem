@extends('template.template-atend')
@section('title', 'Atendimento')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

use App\Models\Agenda;
use App\Models\Comissoe;
use App\Models\Cliente;
use App\Models\Atendente;

//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$atendente = Atendente::where('name', '=', $_SESSION['name_user'])->first();

$totalAulasHoje = Agenda::where('data', '=', $hoje)->where('atendente', '=', $atendente->id)->count();
$totalAulasMes = Agenda::where('data', '>=', $dataInicioMes)->where('data', '<=', $hoje)->where('atendente', '=', $atendente->id)->count();


$totalComissoesHoje = 0;
$tabela = Comissoe::where('data', '=', $hoje)->where('atendente', '=', $_SESSION['name_user'])->get();
foreach ($tabela as $tab) {
 $totalComissoesHoje = $totalComissoesHoje + $tab->value;
}
$totalComissoesHoje = number_format($totalComissoesHoje, 2, ',', '.');


$totalComissoesMes = 0;
$tabela = Comissoe::where('data', '>=', $dataInicioMes)->where('data', '<=', $hoje)->where('atendente', '=', $_SESSION['name_user'])->get();
foreach ($tabela as $tab) {
 $totalComissoesMes = $totalComissoesMes + $tab->value;
}
$totalComissoesMes = number_format($totalComissoesMes, 2, ',', '.');

?>

<div class="row">
  <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Atendimentos Hoje</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAulasHoje ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Atendimentos Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalAulasMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Comissões Hoje</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo $totalComissoesHoje ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Comissões Mês</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo $totalComissoesMes ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="text-xs font-weight-bold text-secondary text-uppercase mt-4">Agenda do Dia</div>
<hr> 
<div class="row">
<?php
  $tabela = Agenda::where('data', '=', $hoje)->where('atendente', '=', $_SESSION['name_user'])->where('status_baixa', '=', 0)->orderby('time', 'asc')->get();
  foreach ($tabela as $tab) {
    $nome_cliente = Cliente::where('name', '=', $tab->name_client)->first();
  ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-danger text-uppercase">{{$nome_cliente->name}}</div>
                        <div class="text-xs text-secondary"><b>{{$nome_cliente->fone}}</b></div>
                        <div class="text-xs text-secondary"><b>{{$tab->description}}</b></div>
                        
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x  text-danger"></i><br>
                        <span class="text-xs">{{$tab->time}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php } ?>
</div>

@endsection