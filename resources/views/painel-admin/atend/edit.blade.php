@extends('template.template-admin')
@section('title', 'Editar Atendente')
@section('content')
<h6 class="mb-4"><i> EDITAR ATENDENTE</i></h6><hr>
<form method="POST" action="{{route('atend.editar', $item)}}">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome</label>
                <input value="{{$item->name}}" type="text" class="form-control" name="name" >
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">CPF</label>
                <input value="{{$item->cpf}}" type="text" class="form-control" id="cpf" name="cpf">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input value="{{$item->email}}" type="email" class="form-control" id="" name="email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="exampleInputEmail1">Endereço</label>
                <input value="{{$item->endereco}}" type="text" class="form-control" id="endereco" name="endereco">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone</label>
                <input value="{{$item->fone}}" type="text" class="form-control" id="telefone" name="fone">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Expecialização A</label>
                <select class="form-control" name="expec1">
                    <?php
                        use App\Models\service;
                        $tabela = service::all();    
                    ?>
                    @foreach ($tabela as $item2)
                        <option value="{{$item2->description}}">{{$item2->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Expecialização B</label>
                <select class="form-control" name="expec2">
                    @foreach ($tabela as $item3)
                        <option value="{{$item3->description}}">{{$item3->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <input value="{{$item->cpf}}" type="hidden" name="oldCpf">
    <input value="{{$item->email}}" type="hidden" name="oldEmail">
    <input value="{{$item->id}}" type="hidden" name="oldId">
    <p align="right">
    <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection