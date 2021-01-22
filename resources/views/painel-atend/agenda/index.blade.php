@extends('template.template-atend')
@section('title', 'Solicitações')
@section('content')
<?php 
@session_start();
if(@$_SESSION['level_user'] != 'atend'){ 
  echo "<script language='javascript'> window.location='./' </script>";
}
$data = implode('/', array_reverse(explode('-', date('Y-m-d'))));
?>
<!-- DataTales Example -->
    <div class="card-body col-md-3 ml-2" style="background: #4E73DF; border-radius: 10px">
        <h6 class="mb-4" style="color:white"><i>Agenda do dia {{$data}}</i></h6><hr>
        @foreach($agenda_hora as $item)
            <a href="{{route('painel-atendimentos-agendas.inserir', $item->hora)}}" class="btn btn-success mb-2 mt-2 " style="margin-left: 10px">{{$item->hora}}</a>
        @endforeach
    </div>
@endsection