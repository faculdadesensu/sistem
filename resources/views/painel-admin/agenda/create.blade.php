@extends('template.template-admin')
@section('title', 'Cadastro Agenda')
@section('content')

<?php 
@session_start();

use App\Models\Service;
use App\Models\Atendente;
use App\Models\Cliente;
use App\Models\Hora;

$tabela = service::all();
$atendente_list = atendente::all();
$cliente_list = cliente::all();
$hora = Hora::all();

$name_user = @$_SESSION['name_user']; 
?>
<h6 class="mb-4"><i>Cadastro Agenda</i></h6><hr>
<form method="POST" action="{{route('agendas.insert')}}">
    @csrf
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome cliente</label>
                <select class="form-control" name="name_client" required>
                    @foreach ($cliente_list as $item)
                        <option  name="name" value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone Cliente</label>
                <input type="text" class="form-control" id="fone" name="fone_client" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Atendente</label>
                <select class="form-control" name="atendente" required>
                    @foreach ($atendente_list as $item)
                        <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Data</label>
                <input type="date" class="form-control" id="" name="date" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Horário</label>
                <select class="form-control" name="time" required>
                    @foreach ($hora as $item)
                        <option value="{{$item->hora}}">{{$item->hora}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Serviço</label>
                <select class="form-control" name="description" required>
                    @foreach ($tabela as $item)
                        <option value="{{$item->description}}">{{$item->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="number" class="form-control" id="preco" name="value_service">
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
    <p align="right">
    <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection