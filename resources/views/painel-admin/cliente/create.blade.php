@extends('template.template-admin')
@section('title', 'Cadastro de Clientes')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE CLIENTES</i></h6><hr>
<form method="POST" action="{{route('clientes.insert')}}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone</label>
                <input type="text" class="form-control" id="fone" name="fone">
            </div>
        </div>
    </div> 
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection