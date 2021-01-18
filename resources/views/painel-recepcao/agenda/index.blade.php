@extends('template.template-recep')
@section('title', 'Agenda')
@section('content')
<?php
@session_start();

use App\Models\ContasReceberes;
use App\Models\Agenda;

if(@$_SESSION['level_user'] != 'recep'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

if(!isset($id)){
  $id = "";
}

if(!isset($id2)){
  $id2 = "";
}
?>

<h6 class="mb-4"><i> AGENDA</i></h6><hr>

<a href="{{route('painel-recepcao-agendas.inserir')}}" type="button" class="mt-2 mb-4 btn btn-primary">Nova Agenda</a>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Data</th>
          <th>Horário</th>
          <th>Nome Cliente</th>
          <th>Telefone Cliente</th>
          <th>Atendente</th>
          <th>Responsavel por agenda</th>
          <th>Serviço</th>
          <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          @foreach($agenda as $item)
          <?php 
            $data = implode('/', array_reverse(explode('-', $item->data)));
            $value = implode(',',explode('.', $item->value_service));
            
            ?>
            <tr>
              <td>{{$data}}</td>
              <td>{{$item->time}}</td>
              <td>{{$item->name_client}}</td>
              <td>{{$item->fone_client}}</td>
              <td>{{$item->atendente}}</td>
              <td>{{$item->create_by}}</td>
              <td>{{$item->description}}</td>
              <td>R$ {{$value}}</td>
              <td>
              <a title="Finalizar Atendimento" href="{{route('painel-recepcao-agendas.modal-cobrar', $item->id)}}"><i class="fas  fa-thumbs-up fa-frog text-success mr-3"></i></a>
              <a title="Editar agenda" href="{{route('painel-recepcao-agendas.edit', $item)}}"><i class="fas fa-edit text-info mr-3"></i></a>
              <a title="Excluir agenda" href="{{route('painel-recepcao-agendas.modal', $item->id)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
              </td>
            </tr>
          @endforeach 
        </tbody>
      </table>
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
        <form method="POST" action="{{route('painel-recepcao-agendas.delete', $id)}}">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-danger">Excluir</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal Cobrança -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Finalizar atendimento?</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-md-6">
        <form method="POST" action="{{route('painel-recepcao-agendas.cobrar')}}">
          @csrf
          @php
            $cliente = Agenda::where('id', '=', $id2)->first();
            $value = implode(',',explode('.', @$cliente->value_service));
          @endphp
          <div>
            <ul>
              <li>
                Cliente: {{@$cliente->name_client}}
              </li>
              <li>
                Descrição do serviço: {{@$cliente->description}}
              </li>
              <li>
                Valor a receber: R$ {{$value}}
              </li>
              <li>
                Atendente: {{@$cliente->atendente}}
              </li>
            </ul>
          </div>
            <div align="right">
              <input type="hidden" value="{{$id2}}" name="id_agenda">
              <input type="hidden" value="{{@$cliente->value_service}}" name="value_service">
              <input type="hidden"  value="{{@$cliente->description}}" name="descricao">
              <input type="hidden" value="{{@$cliente->name_client}}" name="name_client">
              <input type="hidden" value="{{@$cliente->atendente}}" name="atendente">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Finalizar</button>
            </div>
        </form>
      </div>
      <div class="col-md-6">
        <span> Histórico do cliente</span>
          <div class="mt-02">
            @php
                $historyClient = ContasReceberes::where('client', '=', @$cliente->name_client)->orderby('id', 'desc')->get();
              
            @endphp
            @foreach($historyClient as $item)            
            <?php $data = implode('/', array_reverse(explode('-', @$item->date)));?>
            <ul>
              <li>
                Nome: {{@$item->client}}<br>
                Serviço: {{@$item->descricao}}<br>      
                Valor pago: {{@$item->value}}<br>
                Atendente: {{@$item->atendente}}<br>
                Data: {{$data}}<br>
                <span><i class="fas fa-check text-success <?php if(@$item->status_pagamento != 'Sim'){ ?> text-danger <?php }?> "> Status Pagamento</i></span>
              </li>
            </ul>
            <hr>
            @endforeach
            </div>
      </div>
      </div>
    </div>
  </div>
</div>
<?php 
if(@$id != ""){
  echo "<script>$('#exampleModal').modal('show');</script>";
}

if(@$id2 != ""){
  echo "<script>$('#exampleModal2').modal('show');</script>";
}
?>
@endsection