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

if(isset($data)){
    @$data = $data;
}else{
    @$data = date('Y-m-d');
}
?>
<div class="row">
  <div class="col-md-4 mb-4 border-left-primary">
    <h6><i>SELECIONE UMA DATA PARA PESQUISA</i></h6>
    <form class="form-inline mb-4" action="{{route('agendas.busca')}}" method="POST">
      @csrf
      <input class="form-control col-md-5 mt-2" name="data" value="{{$data}}" type="date" >
      <button class="btn btn-outline-info mt-2 col-md-4 " type="submit">Buscar</button>
    </form>
  </div>
  <div class="col-md-4 mt-4 ">
    <h4 class="mb-4" style="color:#522b0d; text-align:center;">AGENDA DO DIA {{implode('/', array_reverse(explode('-', $data)))}}</h4><hr>
  </div>
</div>

 
<div class="row">
    @foreach ($atendentes as $atendente)
    <div class="col-md-4 mb-4">
      <div class="card-body " style="background: #fff; border-radius: 10px; box-shadow: 0px 0px 50px 10px rgba(102,54,16, .09)">
        
        <h4>{{$atendente->name}}</h4>
        <hr>
        @foreach($agenda_hora as $item)
            <?php $check = Agenda::where('data', '=', $data)->where('time', '=', $item->hora)->where('atendente', '=', $atendente->name)->where('status_baixa', '=', 0)->first(); ?>
            @if (!isset($check))
                <a href="{{route('painel-atendimentos-agendas.inserir', [$item->hora, $data, $atendente->name])}}" class="btn btn-outline-info mb-2 mt-2 " style="margin-left: 10px">{{$item->hora}}</a>
            @else 
                <a href="{{route('painel-atendimentos-agendas.modal', [$check->id, $data])}}" class="btn btn-primary mb-2 mt-2 " style="margin-left: 10px">{{$item->hora}}</a>
            @endif
        @endforeach
      </div>
    </div>
      
    @endforeach
</div>

<!-- Modal Relatório de atendimento -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detalhes Agenda</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
              <?php $check2 = Agenda::where('id', '=', $id)->first(); ?>
              <p>Cliente: {{@$check2->name_client}}</p>
              <p>Descrição: {{@$check2->description}}</p>
              <p>Valor: R$ {{@$check2->value_service}}</p>

          </div>
          <div class="modal-footer">
              <a href="{{route('painel-recepcao-agendas.index')}}" class="btn btn-secondary mb-2 mt-2 " style="margin-left: 10px">Cancelar</a>
              <form method="POST" action="{{route('painel-atendimentos-agendas.delete', [$id, $data])}}">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger">Excluir</button>
              </form>
             
              <form method="POST" action="{{route('painel-atendimentos-agendas.cobrar')}}">
                  @csrf
                  <input type="hidden" name="id_agenda" value="{{$id}}">
                  <input type="hidden" name="descricao" value="{{@$check2->description}}">
                  <input type="hidden" name="name_client" value="{{@$check2->name_client}}">
                  <input type="hidden" name="value_service" value="{{@$check2->value_service}}">
                  <input type="hidden" name="atendente" value="{{@$check2->atendente}}">
                  <input type="hidden" name="responsavel_receb" value="{{@$_SESSION['name_user']}}">
                  <button type="submit" class="btn btn-primary ml-5" style="padding: 6px 50px">Finalizar</button>
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