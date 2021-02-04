@extends('template.template-recep')
@section('title', 'Editar Cliente')
@section('content')
<h6 class="mb-4"><i> EDITAR CLIENTE</i></h6><hr>
<form method="POST" action="{{route('painel-recepcao-clientes.editar', $item)}}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome</label>
                <input value="{{$item->name}}" type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone</label>
                <input value="{{$item->fone}}" type="text" class="form-control" id="fone" name="fone">
            </div>
        </div>
    </div>
    <input value="{{$item->name}}" type="hidden" name="oldName">
    <input value="{{$item->fone}}" type="hidden" name="oldFone">
    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection