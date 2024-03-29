@extends('template.template-admin')
@section('title', 'Comissões')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'admin' ){ 
  echo "<script language='javascript'> window.location='./' </script>";
}

use App\Models\Service;

?>
<div class="mb-4">
  <h4><i>RELATÓRIO DE COMISSÕES</i></h4>
  <h5><i><b>{{$dataInicial}}</b> à <b>{{$dataFinal}}</b> <?php if (!$atendente == 0){ ?> - Colaborador: <b>{{$atendente}}</b> <?php }else{ ?> <b>Comissão Geral</b><?php } ?></i></h5>
</div>
<form action="{{route('comissoes.index')}}" method="GET" target="_blank">
  <input type="hidden" value="{{$dataInicial}}" name="dataInicial">
  <input type="hidden" value="{{$dataFinal}}" name="dataFinal">
  <input type="hidden" value="{{$atendente}}" name="atendente">
  <button type="submit" class="mt-4 mb-4 btn btn-primary">Imprimir</button>
</form>
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Data</th>
            <?php if ($atendente == 0){ ?> <th>Atendente</th><?php }?>
            <th>Descrição</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
             <?php
              $value = implode(',', explode('.', $item->value));
              $data = implode('/', array_reverse(explode('-', $item->data)));
              $service = Service::where('id', '=', $item->descricao)->first();
             ?>
              <tr>
                <td>{{$data}}</td>              
                <?php if ($atendente == 0){ ?> <td> {{$item->atendente}}</td><?php } ?>
                <td>{{$service->description}}</td>
                <td>{{$value}}</td>
              </tr>
            @endforeach 
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection