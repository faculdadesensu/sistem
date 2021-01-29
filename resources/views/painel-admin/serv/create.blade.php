
@extends('template.template-admin')
@section('title', 'Inserir Instrutores')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE RECEPCIONISTA</i></h6><hr>
<form method="POST" action="{{route('service.insert')}}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Descrição</label>
                <input type="text" class="form-control" name="description" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="text" id="money" class="form-control" name="valor" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Comissão</label>
                <input type="text" id="money" class="form-control" name="comissao" required>
            </div>
        </div>
    </div>
    <p align="right">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection