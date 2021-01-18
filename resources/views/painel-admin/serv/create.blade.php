
@extends('template.template-admin')
@section('title', 'Inserir Instrutores')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE RECEPCIONISTA</i></h6><hr>
<form method="POST" action="{{route('service.insert')}}">
    @csrf
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Descrição</label>
            <input type="text" class="form-control" name="description" required>
        </div>
        <p align="right">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </div>
</form>
@endsection