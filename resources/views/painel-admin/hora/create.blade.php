
@extends('template.template-admin')
@section('title', 'Inserir Instrutores')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE RECEPCIONISTA</i></h6><hr>
<form method="POST" action="{{route('hora.insert')}}">
    @csrf
    <div class="col-md-2">
        <div class="form-group">
            <label for="exampleInputEmail1">Horário</label>
            <input type="time" class="form-control" name="hora" required>
        </div>
        <p align="right">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </div>
</form>
@endsection