@extends('template.template-recep')
@section('title', 'Contas a Receber')
@section('content')

<?php
@session_start();
if (@$_SESSION['level_user'] != 'recep') {
    echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
    $id = "";
}
if (!isset($id2)) {
    $id2 = "";
}

if (!isset($id3)) {
    $id3 = "";
}

use App\Models\Movimentacao;
use App\Models\Atendente;
use App\Models\ContasReceberes;
use App\Models\Cliente;
use App\Models\Service;

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
<div class="row">
    <h3 class="mt-4 ml-4"><b>CONTAS A RECEBER</b></h3><hr>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas do Dia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{@$total_entradas}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <button  class="btn btn-lg btn-block mb-2" style="background-color: #D9D9D9; color:#663610">
            <div class="row">
                <div class="col-sm-2 offset-sm-1">
                    DATA
                </div>
                <div class="col-sm-2 overflow-b">
                    CLIENTE
                </div>
                <div class="col-sm-2 overflow-b">
                    ATENDENTE
                </div>
                <div class="col-sm-2 overflow-b">
                    DESCRIÇÃO
                </div>
                <div class="col-sm-2 overflow-b">
                    VALOR
                </div>
            </div>
        </button>
        @foreach($itens as $item)
            <?php
                $data = implode('/', array_reverse(explode('-', $item->date)));
                $data2 = implode('/', array_reverse(explode('-', $item->data_pagamento)));
                $value = implode(',', explode('.', $item->value));

                $atendente = Atendente::where('id', '=', $item->atendente)->first();
                $cliente = Cliente::where('id', '=', $item->client)->first();
                $service = Service::where('id', '=', $item->descricao)->first();
             
            ?>
            <form action="{{route('contas-receber.modalPrincipal', $item->id)}}" method="GET" >
                @csrf
                <button type="submit" class="btn btn-outline-info btn-lg btn-block mb-2">
                    <div class="row">
                        <div class="col-sm-2 offset-sm-1">
                            {{$data}} 
                        </div>
                        <div class="col-sm-2 overflow-b">
                            {{$cliente->name}}
                        </div>
                        <div class="col-sm-2 overflow-b">
                            {{$atendente->name}}
                        </div>
                        <div class="col-sm-2 overflow-b">
                            {{$service->description}}
                        </div>
                        <div class="col-sm-2 overflow-b">
                            R$ {{$value}}
                        </div>
                    </div>
                </button>
            </form>
        @endforeach
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
        </div>
        <div class="modal-body">
          Deseja Realmente Excluir este Registro?
        </div>
        <div class="modal-footer">
            <a href="{{route('contas-receber.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
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
            </div>
            <div class="modal-body">
                Deseja receber este pagamento?
                <hr><p><b>Recebido por: <br>{{$_SESSION['name_user']}}</b></p>
                <?php
                  
                    $contaReceber = ContasReceberes::where('id', '=', $id2)->first();
                    $atendente2 = Atendente::where('id', '=', @$contaReceber->atendente)->first();
                ?>
                <hr>
                <p><b>Dados do atendimento</b></p>
                <b>Cliente</b><br>
                <p>{{@$contaReceber->client}}</p>
                <b>Atendente</b><br>

                <p>{{@$atendente2->name}}</p>
                <b>Valor</b><br>
                <p>R$ {{@$contaReceber->value}}</p>
                <b>Descrição</b><br>
                <p>{{@$contaReceber->descricao}}</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('contas-receber.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
                <form method="POST" action="{{route('contas-receber.baixa', $id2)}}">
                    @csrf
                    @method('put')
                   
                    <input type="hidden" name='id' value="{{$id2}}">
                    <input type="hidden" name='value' value="">
                    <button type="submit" class="btn btn-primary">Receber</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Baixa escolha de opções -->
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selecione uma opção</h5>
            </div>
            <div class="modal-body">
                Selecione uma opção para esta conta a receber
            </div>
            <div class="modal-footer">
                <a href="{{route('contas-receber.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
                <form method="GET" action="{{route('contas-receber.modal', $id3)}}">
                    @csrf
                    <button type="submit" class="btn btn-danger mr-4">Excluir</button>
                </form>
                <form method="GET" action="{{route('contas-receber.modal-baixa', $id3)}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Receber Pagamento</button>
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

if (@$id3 != "") {
    echo "<script>$('#exampleModal3').modal('show');</script>";
}
?>

@endsection