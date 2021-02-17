@extends('template.template-recep')
@section('title', 'Moviemntações')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'recep'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
if(!isset($id)){
  $id = "";
}
use App\Models\Movimentacao;

$total_entradas = 0;
$total_saidas = 0;
$saldo = 0;

$data = date('Y-m-d');

$tabela = Movimentacao::where('data', '=', $data)->get();

foreach($tabela as $tab){

  if ($tab->tipo == 'Entrada') {
    @$total_entradas = $total_entradas + $tab->value;
  } else {
    @$total_saidas = $total_saidas + $tab->value;
  }
}

$saldo = $total_entradas - $total_saidas;

$total_entradas = number_format($total_entradas, 2, ',', '.');          
$total_saidas = number_format($total_saidas, 2, ',', '.');          
$saldo = number_format($saldo, 2, ',', '.'); 

if($saldo < 0){
  $classe = 'text-danger';
  $classe2 = 'border-left-danger';
}else{
  $classe = 'text-success';
  $classe2 = 'border-left-success';
}

?>
<div class="row">
  <h3 class="mt-4 ml-4"><i> MOVIMENTAÇÃO DO DIA</i></h3><hr>
<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4 " >
  <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
          <div class="row no-gutters align-items-center">
              <div class="col mr-2 ">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1" >Entradas</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo @$total_entradas ?></div>
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
                  <div class="h5 mb-0 font-weight-bold text-gray-800">R$ <?php echo @$total_saidas ?></div>
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
                  <div class="text-xs font-weight-bold {{$classe}} text-uppercase mb-1">Total</div>
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

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">

      <div class="card shadow mb-4">
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-lg btn-block mb-2" >
                <div class="row">
                  <div class="col-xl-2  overflow-b offset-xl-1">
                    Data
                  </div>
                  <div class="col-xl-2 ">
                    Descrição
                  </div>                  
                  <div class="col-xl-2 ">
                    Respnsável
                  </div>                  
                  <div class="col-xl-2 overflow-b">
                    Entradas
                  </div>
                  <div class="col-xl-2 overflow-b">
                    Saidas
                  </div>
                </div>
            </button>
            @foreach($itens as $item)
                <?php
                    $data2 = implode('/', array_reverse(explode('-', $item->data)));
                    $value2 = implode(',', explode('.', $item->value));
                ?>
                    <button type="submit" class="btn btn-outline-info btn-lg btn-block" disabled >
                      <div class="row">
                        <div class="col-xl-2  overflow-b  offset-xl-1">
                          {{$data2}}
                        </div>
                        <div class="col-xl-2 overflow-b">
                          {{$item->descricao}} 
                        </div>
                        <div class="col-xl-2 overflow-b">
                          {{$item->recep}} 
                        </div>
                        @if ($item->tipo == 'Entrada')
                          <div class="col-xl-2 overflow-b">
                            {{$value2}}
                          </div>
                          <div class="col-xl-2 overflow-b">
                            ---
                          </div>
                        @else
                          <div class="col-xl-2 overflow-b">
                            ---
                          </div>
                          <div class="col-xl-2 overflow-b">
                            {{$value2}}
                          </div>
                        @endif
                      </div>
                  </button>
            @endforeach
        </div>
    </div>
    

<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })
  });
</script>
@endsection