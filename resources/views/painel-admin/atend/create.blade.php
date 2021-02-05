@extends('template.template-admin')
@section('title', 'Cadastro Atendentes')
@section('content')
<h6 class="mb-4"><i>CADASTRO DE ATENDENTES</i></h6><hr>
<form method="POST" action="{{route('atend.insert')}}">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="" name="email">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="exampleInputEmail1">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Telefone</label>
                <input type="text" class="form-control" id="fone" name="fone">
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
                    @foreach ($tabela as $item)
                        <option value="{{$item->description}}">{{$item->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Expecialização B</label>
                <select class="form-control" name="expec2">
                    @foreach ($tabela as $item)
                        <option value="{{$item->description}}">{{$item->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <p align="right">
    <button type="submit" class="btn btn-primary">Salvar</button>
    </p>
</form>
@endsection