@extends('template.template-admin')
@section('title', 'Administrador')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'admin'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
if(!isset($id)){
  $id = "";
}

if(!isset($id2)){
  $id2 = "";
}
?>
<a href="{{route('atend.inserir')}}" type="button" class="mt-4 mb-4 btn btn-primary">Novo Atendente</a>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Nome</th>
          <th>CPF</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Expecialização-1</th>
          <th>Expecialização-2</th>
          <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach($atendentes as $item)
            <tr>
              <td>{{$item->name}}</td>
              <td>{{$item->cpf}}</td>
              <td>{{$item->email}}</td>
              <td>{{$item->fone}}</td>
              <td>{{$item->expec1}}</td>
              <td>{{$item->expec2}}</td>
              <td>
              <a href="{{route('atend.history', $item->id)}}"><i class="fas fa-history text-success mr-1"></i></a>
              <a href="{{route('atend.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
              <a href="{{route('atend.modal', $item->id)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
              </td>
            </tr>
          @endforeach 
        </tbody>
      </table>
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
        <form method="POST" action="{{route('atend.delete', $id)}}">
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
        <h5 class="modal-title" id="exampleModalLabel">Histórico de Atendimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-14">
            <div class="mt-02 ">
              @php
                use App\Models\Atendente;
                use App\Models\ContasReceberes;

                $atendente = Atendente::where('id', '=', $id2)->first();
                $historyAtendente = ContasReceberes::where('atendente', '=', @$atendente->name)->orderby('id', 'desc')->get();
                
              @endphp
              @foreach($historyAtendente as $item)            
              <?php $data = implode('/', array_reverse(explode('-', @$item->date)));?>
              <ul>
                <li>
                  <b>Nome:</b> {{@$item->client}} - 
                  <b>Serviço:</b> {{@$item->descricao}} -    
                  <b>Valor pago:</b> R$ {{@$item->value}} - 
                  <b>Data:</b> {{$data}}<br>
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