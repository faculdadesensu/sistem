@extends('template.template-atend')
@section('title', 'Agenda')
@section('content')
<?php 
use App\Models\Agenda;
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

if(!isset($id)){
  $id = "";
}

if(isset($data)){
    @$data = $data;
}else{
    @$data = date('Y-m-d');
}

?>
<!-- DataTales Example -->
<div class="card-body col-lg-4 col-md-8 col-sm-12 ml-2" style="background: #fff; border-radius: 10px; box-shadow: 0px 0px 10px 5px rgba(102,54,16, 0.2)">
    <form class="form-inline mb-4" action="{{route('agendas.busca')}}" method="POST">
        @csrf
        <input class="form-control col-md-7 mb-2 mr-2" name="data" value="{{$data}}" type="date" >
        <button class="btn btn-primary col-md-4 " type="submit">Busar</button>
      </form>
    <h4 class="mb-4" style="color:#522b0d;"><i>AGENDA DO DIA {{implode('/', array_reverse(explode('-', $data)))}}</i></h4><hr>
    @foreach($agenda_hora as $item)
        <?php $check = Agenda::where('data', '=', $data)->where('time', '=', $item->hora)->where('atendente', '=', $_SESSION['name_user'])->where('status_baixa', '=', 0)->first(); ?>
        @if (!isset($check))
            <a href="{{route('painel-atendimentos-agendas.inserir', [$item->hora, $data])}}" class="btn btn-primary mb-2 mt-2 " style="margin-left: 10px">{{$item->hora}}</a>
        @else 
            <a href="{{route('painel-atendimentos-agendas.modal', [$check->id, $data])}}" class="btn btn-danger mb-2 mt-2 " style="margin-left: 10px">{{$item->hora}}</a>
        @endif
    @endforeach
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deletar horario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            Deseja Realmente Excluir esta Agenda?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <form method="POST" action="{{route('painel-atendimentos-agendas.delete', [$id, $data])}}">
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