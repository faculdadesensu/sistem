@extends('template.template-admin')
@section('title', 'Editar Serviço')
@section('content')
<h6 class="mb-4">EDITAR SERVIÇO</i></h6><hr>
<form method="POST" action="{{route('service.editar', $item)}}">
    @csrf
    @method('put')
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Descrição</label>
                <input type="text" value="{{$item->description}}" class="form-control" name="description" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="text" value="{{$item->valor}}" id="money" class="form-control" name="valor" required>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Comissão</label>
                <input type="text" value="{{$item->comissao}}" id="money2" class="form-control" name="comissao" required>
            </div>
        </div>
    </div>
    
    <p align="right">
        <input type="hidden" value="{{$item->description}}" name="old">
        <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection