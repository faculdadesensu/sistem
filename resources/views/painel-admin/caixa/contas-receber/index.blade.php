@extends('template.template-admin')
@section('title', 'Contas a Pagar')
@section('content')

<?php
@session_start();
if (@$_SESSION['level_user'] != 'admin') {
    echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
    $id = "";
}
if (!isset($id2)) {
    $id2 = "";
}

use App\Models\Movimentacao;

$total_entradas = 0;

$data = date('Y-m-d');

$tabela = Movimentacao::where('data', '=', $data)->get();

foreach($tabela as $tab){
  if ($tab->tipo == 'Entrada') {
    @$total_entradas = $total_entradas + $tab->value;
  } 
}

$total_entradas = number_format($total_entradas, 2, ',', '.');

?>
<h6 class="mb-4"><i> CONTAS A RECEBER</i></h6><hr>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Data Atendimento</th>
                        <th>Data Pagamento</th>
                        <th>Nome Cliente</th>
                        <th>Responsavel baixa</th>
                        <th>Atendente</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itens as $item)
                        <?php 
                            $data = implode('/', array_reverse(explode('-', $item->date)));
                            $data2 = implode('/', array_reverse(explode('-', $item->data_pagamento)));
                            $value = implode(',', explode('.', $item->value));
                        ?>
                        <tr>
                            <td><i class="fas fa-square mr-1 text-success <?php if($item->status_pagamento != 'Sim'){ ?> text-danger <?php } ?>"></i></td>
                            <td>{{$data}}</td>
                            <td>@if ($data2 == "")
                                Pendente
                            @endif{{$data2}}</td>
                            <td>{{$item->client}}</td>
                            <td>{{$item->responsavel_receb}}</td>
                            <td>{{$item->atendente}}</td>
                            <td>{{$item->descricao}}</td>
                            <td>R$ {{$value}}</td>
                            @if(@$item->status_pagamento != 'Sim')
                            <td>                                   
                                <a title="Finalizar Recebimento" href="{{route('contas-receber.modal-baixa', $item->id)}}"><i class="fas fa-coins text-success mr-3"></i></a>
                                <a title="Excluir Recebimento" href="{{route('contas-receber.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
                            </td>
                            @else
                            <td>Finalizado</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row mb-4 mr-2 " align="right">
        <div class="col-md-12" >
            <span class="">Entradas do Dia: <span class="text-success">R$ {{@$total_entradas}}</span></span>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": true
        })
    });
</script>


<!-- Modal Delete -->
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
          <form method="POST" action="{{route('contas-receber.delete', $id)}}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Baixa Recebimento -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baixar Recebimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja realmente finalizar esse recebimento?

                <hr><p><b>Responsável por receber pagamento : <br>{{$_SESSION['name_user']}}</b></p>

            </div>
            <div class="modal-footer">
                
                <form method="POST" action="{{route('contas-receber.baixa', $id2)}}">
                    @csrf
                    @method('put')
                   
                    <input type="hidden" name='id' value="{{$id2}}">
                    <input type="hidden" name='value' value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (@$id != "") {
    echo "<script>$('#exampleModal').modal('show');</script>";
}

if (@$id2 != "") {
    echo "<script>$('#exampleModal2').modal('show');</script>";
}
?>

@endsection