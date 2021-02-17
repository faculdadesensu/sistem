@extends('template.template-recep')
@section('title', 'Recepção')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'recep'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

use App\Models\ContasPagares;
use App\Models\Movimentacao;

//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$totalContasVencidas = ContasPagares::where('data_venc', '<', $hoje)->where('status', '!=', 'Pago')->count();

//TOTALIZAR ENTRADAS e SAÍDAS
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

?>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas</div>
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
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saídas</div>
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
<div class="text-xs font-weight-bold text-secondary text-uppercase mt-4">CONTAS À PAGAR</div>
<hr> 
<div class="row">
<?php
  $tabela = ContasPagares::where('status', '!=', 'Pago')->orderby('data_venc', 'asc')->get();
  foreach ($tabela as $tab) {
    $data = implode('/', array_reverse(explode('-', $tab->data_venc)));
?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold  text-danger text-uppercase">{{$tab->descricao}}</div>
                        <div class="text-xs text-secondary">R$ {{$tab->value}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x  text-danger"></i><br>
                        <span class="text-xs">{{$data}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
@endsection