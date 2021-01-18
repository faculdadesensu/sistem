@extends('template.template-admin')
@section('title', 'Editar Serviço')
@section('content')
<h6 class="mb-4">EDITAR SERVIÇO</i></h6><hr>
<form method="POST" action="{{route('service.editar', $item)}}">
    @csrf
    @method('put')
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Descrição</label>
            <input type="text" value="{{$item->description}}" class="form-control" name="description" required>
        </div>
        <p align="right">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </p>
    </div>
</form>
@endsection