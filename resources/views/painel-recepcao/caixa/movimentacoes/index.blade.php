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
    @$total_entradas = $total_entrada + $tab->value;
  } else {
    @$total_saidas = $total_saidas + $tab->value;
  }
}

$saldo = $total_entradas - $total_saidas;

$total_entradas = number_format($total_entradas, 2, ',', '.');          
$total_saidas = number_format($total_saidas, 2, ',', '.');          
$saldo = number_format($saldo, 2, ',', '.');          
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Tipo</th>
          <th>Descrição</th>
          <th>Responsável</th>
          <th>Data</th>
          <th>Entradas</th>
          <th>Saidas</th>
          </tr>
        </thead>
        <tbody>
          @foreach($itens as $item)
          <?php 
            $data = implode('/', array_reverse(explode('-', $item->data)));
            $value = implode(',', explode('.', $item->value));
          ?>
            <tr>
              <td><i class="fas fa-square mr-1 text-success <?php if($item->tipo != 'Entrada'){ ?> text-danger <?php } ?>"></i></td>
              <td>{{$item->descricao}}</td>
              <td>{{$item->recep}}</td>
              <td>{{$data}}</td>
              @if ($item->tipo == 'Entrada')
                <td>{{$value}}</td>
                <td> ---</td>
              @else
              <td>---</td>
              <td>{{$value}}</td>
              @endif
            </tr>
          @endforeach 
        </tbody>
      </table>
    </div>
  </div>
  <div class="row ml-2 mb-4 mr-4">
    <div class="col-md-8">
      <span class="">Entradas do Dia: <span class="text-success">R$ {{@$total_entradas}}</span></span>
      <span class="ml-4 ">Saídas do Dia: <span class="text-danger">R$ {{@$total_saidas}}</span></span>
    </div>
    <div class="col-md-4" align="right">
      <span class="">Saldo do Dia: <span class="text-success <?php if (@$saldo < 0) { ?> text-danger <?php } ?>">R$ {{@$saldo}}</span></span>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $('#dataTable').dataTable({
      "ordering": false
    })
  });
</script>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deletar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja Realmente Excluir este Registro?        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form method="POST" action="{{route('users.delete', $id)}}">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php 
if(@$id != ""){
  echo "<script>$('#exampleModal').modal('show');</script>";
}
?>
@endsection