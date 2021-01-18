@extends('template.template-admin')
@section('title', 'Editar Agenda')
@section('content')

<?php 
@session_start(); 
$name_user = @$_SESSION['name_user'];

use App\Models\Service;
use App\Models\Atendente;
use App\Models\Cliente;

$tabela = Service::all();
$atendente_list = Atendente::all();
$cliente_list = Cliente::all();

?>

<h6 class="mb-4"><i> EDITAR AGENDA</i></h6><hr>
<form method="POST" action="{{route('agendas.editar', $item)}}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome cliente</label>
                <select class="form-control" name="name_client" required>
                @foreach ($cliente_list as $val)
                    <option value="{{$val->name}}" <?php if($item->name_client == $val->name) { ?> selected <?php } ?> >{{$val->name}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone Cliente</label>
                <input type="text" value="{{$item->fone_client}}" class="form-control" id="fone" name="fone_client" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Atendente</label>                
                <select class="form-control" name="atendente" required>
                    @foreach ($atendente_list as $val)
                    <option value="{{$val->name}}" <?php if($item->atendente == $val->name) { ?> selected <?php } ?> >{{$val->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">  
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Data</label>
                <input type="date" value="{{$item->date}}" class="form-control" id="" name="date" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Horário</label>
                <input type="time" value="{{$item->time}}" class="form-control" id="" name="time" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="text" value="{{$item->value_service}}" class="form-control" name="value_service" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Serviço</label>
                <select class="form-control" value="{{$item->description}}" name="description" required>
                    @foreach ($tabela as $val)
                        <option value="{{$val->description}}" <?php if($item->description == $val->description) { ?> selected <?php } ?> >{{$val->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Responsável por agenda</label>
                <input type="text" class="form-control" value="{{$name_user}}" disabled>
                <input type="hidden" class="form-control" value="{{$name_user}}" name="create_by">
            </div>
        </div>
    </div>
    <input value="{{$item->date}}" type="hidden" name="olddate">
    <input value="{{$item->time}}" type="hidden" name="oldtime">
    <p align="right">
    <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection