@extends('template.template-atend')
@section('title', 'Solicitações')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
if(!isset($id)){
  $id = "";
}
?>
<a href="{{route('solicitacoes.inserir')}}" type="button" class="mt-4 mb-4 btn btn-primary">Nova Solicitação</a>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
          <th>Status</th>
          <th>Descrição</th>
          <th>Atendente</th>
          <th>Data</th>
          <th>Valor</th>
          <th>Ações</th>
          </tr>
        </thead>
        <tbody>
            @foreach($solicitacoes as $item)
             <?php
              $value = implode(',', explode('.', $item->value));
              $data = implode('/', array_reverse(explode('-', $item->data)));
             ?>
              <tr>
                <td><i class="ml-5 fas fa-check-circle text-success <?php if($item->status != true){ ?> text-danger <?php } ?>"></i></td>
                <td>{{$item->descricao}}</td>
                <td>{{$item->atendente}}</td>
                <td>{{$data}}</td>
                <td>{{$value}}</td>
                <td>
                  @if($item->status != true)
                    <a href="{{route('solicitacoes.edit', $item)}}"><i class="fas fa-edit text-info mr-1"></i></a>
                    <a href="{{route('solicitacoes.modal', $item->id)}}"><i class="fas fa-trash text-danger mr-1"></i></a>                      
                  @else
                      Pago
                  @endif
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
        <form method="POST" action="{{route('solicitacoes.delete', $id)}}">
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