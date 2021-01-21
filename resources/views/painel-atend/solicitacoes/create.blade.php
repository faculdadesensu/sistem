
@extends('template.template-atend')
@section('title', 'Cadastro de Solicitação')
@section('content')

<?php 
@session_start();

$name_user = @$_SESSION['name_user']; 
?>
<h6 class="mb-4"><i>Cadastro de Solicitação</i></h6><hr>
<form method="POST" action="{{route('solicitacoes.insert')}}">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label for="exampleInputEmail1">Descrição</label>
                <input type="text" class="form-control" name="descricao" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="text" class="form-control" id="money" name="value">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Responsável por Solicitação</label>
                <input type="text" class="form-control" value="{{$name_user}}" disabled>
                <input type="hidden" class="form-control" value="{{$name_user}}" name="atendente">
            </div>
        </div>
    </div>   
    <p align="right">
    <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>

@endsection