@extends('template.template-admin')
@section('title', 'Editar Serviço')
@section('content')
<h6 class="mb-4">EDITAR SERVIÇO</i></h6><hr>
<form method="POST" action="{{route('hora.editar', $item)}}">
    @csrf
    @method('put')
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Hora</label>
            <input type="time" value="{{$item->hora}}" class="form-control" name="hora" required>
        </div>
        <p align="right">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </div>
</form>
@endsection