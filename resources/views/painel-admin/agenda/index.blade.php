@extends('template.template-admin')
@section('title', 'Agenda')
@section('content')
<?php 
@session_start();

if(@$_SESSION['level_user'] != 'admin'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
if(!isset($id)){
  $id = "";
}
?>

<a href="{{route('agendas.inserir')}}" type="button" class="mt-2 mb-4 btn btn-primary">Nova Agenda</a>
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
          <th>Valor R$</th>
          </tr>
        </thead>
        <tbody>
          @foreach($agenda as $item)
          <?php $data = implode('/', array_reverse(explode('-', $item->data)));?>
            <tr>
              <td>{{$data}}</td>
              <td>{{$item->time}}</td>
              <td>{{$item->name_client}}</td>
              <td>{{$item->fone_client}}</td>
              <td>{{$item->atendente}}</td>
              <td>{{$item->create_by}}</td>
              <td>{{$item->description}}</td>
              <td>{{$item->value_service}}</td>
              <td>
              <a href="{{route('agendas.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
              <a href="{{route('agendas.modal', $item->id)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
              </td>
            </tr>
          @endforeach 
        </tbody>
      </table>
    </div>
  </div>
</div>
  <!-- {{$agenda->links()}} -->
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
        <form method="POST" action="{{route('agendas.delete', $id)}}">
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