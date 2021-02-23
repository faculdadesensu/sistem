@extends('template.template-admin')
@section('title', 'Editar Cliente')
@section('content')
<h6 class="mb-4"><i> EDITAR CLIENTE</i></h6><hr>
<form method="POST" action="{{route('clientes.editar', $item)}}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome</label>
                <input value="{{$item->name}}" type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone</label>
                <input value="{{$item->fone}}" type="text" class="form-control" id="telefone" name="fone">
            </div>
            <div align="right">
                <input value="{{$item->name}}" type="hidden" name="oldName">
                <input value="{{$item->fone}}" type="hidden" name="oldFone">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</form>
@endsection