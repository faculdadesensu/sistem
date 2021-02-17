@extends('template.template-recep')
@section('title', 'Contas a Pagar')
@section('content')

<?php
@session_start();
if (@$_SESSION['level_user'] != 'recep') {
    echo "<script language='javascript'> window.location='./' </script>";
}
if (!isset($id)) {
    $id = "";
}

if (!isset($id2)) {
    $id2 = "";
}
if (!isset($id3)) {
    $id3 = "";
}

use App\Models\Movimentacao;

$total_saidas = 0;

$data = date('Y-m-d');

$tabela = Movimentacao::where('data', '=', $data)->get();

foreach($tabela as $tab){
  if ($tab->tipo == 'Saida') {
    @$total_saidas = $total_saidas + $tab->value;
  } 
}

$total_saidas = number_format($total_saidas, 2, ',', '.');

?>

<div class="row">
    <h3 class="mt-4 ml-4 mb-4"><b>CONTAS A PAGAR</b></h3><hr>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saidas do Dia</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{@$total_saidas}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{route('pagar.inserir')}}" type="button" class="mt-2 mb-4 btn btn-primary">Novo Registro</a>



<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <button  class="btn btn-lg btn-block mb-2" style="background-color: #D9D9D9; color:#663610">
            <div class="row">
                <div class="col-sm-2 offset-sm-1">
                    DATA VENCIMENTO
                </div>
                <div class="col-sm-2 overflow-b">
                    Descrição
                </div>
                <div class="col-sm-2 overflow-b">
                    Responsavel Cadastro
                </div>
                <div class="col-sm-2 overflow-b">
                    Arquivo
                </div>
                <div class="col-sm-2 overflow-b">
                    VALOR
                </div>
            </div>
        </button>
        @foreach($itens as $item)
            <?php
                $data = implode('/', array_reverse(explode('-', $item->data_venc)));
                $value = implode(',', explode('.', $item->value));
            ?>
            <form action="{{route('contas-pagar.modalPrincipal', $item->id)}}" method="GET" >
                @csrf
                <button type="submit" class="btn btn-outline-info btn-lg btn-block mb-2">
                    <div class="row">
                        <div class="col-sm-2 offset-sm-1">
                            {{$data}} 
                        </div>
                        <div class="col-sm-2 overflow-b">
                            {{$item->descricao}}
                        </div>
                        <div class="col-sm-2 overflow-b">
                            {{$item->resp_cad}}
                        </div>
                        <div class="col-sm-2 overflow-b">
                            @if($item->upload != '')<a href="{{ URL::asset(''.$item->upload)}}" target="_blank" ><i class="fas fa-paperclip mr-1 text-success" ></i>Baixar </a>@else Sem Arquivo @endif
                        </div>
                        <div class="col-sm-2 overflow-b">
                            R$ {{$value}}
                        </div>
                    </div>
                </button>
            </form>
        @endforeach
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Deletar Registro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Deseja Realmente Excluir este Registro?
        </div>
        <div class="modal-footer">
            <a href="{{route('pagar.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
          <form method="POST" action="{{route('pagar.delete', $id)}}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Excluir</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Baixa Recebimento -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baixar Pagamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <p><b>Pago por</b> <br>{{$_SESSION['name_user']}}</p>
                <?php
                    use App\Models\ContasPagares;
                    $item = ContasPagares::where('id', '=', $id2)->first(); 
                ?>
                <b>Responsavel por Cadastro</b><br>
                <p>{{@$item->resp_cad}}</p>
                <b>Valor</b><br>
                <p>R$ {{@$item->value}}</p>
                <b>Descrição</b><br>
                <p>{{@$item->descricao}}</p>
            </div>
            <div class="modal-footer">
                <a href="{{route('pagar.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
                <form method="POST" action="{{route('pagar.baixa', $id2)}}">
                    @csrf
                    @method('put')
                    <input type="hidden" name='id' value="{{$id2}}">
                    <input type="hidden" name='date' value="{{date('Y-m-d')}}">
                    
                    <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Baixa escolha de opções -->
<div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selecione uma opção</h5>
            </div>
            <div class="modal-body">
                Selecione uma opção para esta conta a pagar
            </div>
            <div class="modal-footer">
                <a href="{{route('pagar.index')}}" type="button" class="mt-4 mb-4 btn btn-secondary">Cancelar</a>
                <form method="GET" action="{{route('pagar.modal', $id3)}}">
                    @csrf
                    <button type="submit" class="btn btn-danger mr-4">Excluir</button>
                </form>
                <form method="GET" action="{{route('pagar.modal-baixa', $id3)}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Receber Pagamento</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
if (@$id != "") {
    echo "<script>$('#exampleModal').modal('show');</script>";
}

if (@$id2 != "") {
    echo "<script>$('#exampleModal2').modal('show');</script>";
}
if (@$id3 != "") {
    echo "<script>$('#exampleModal3').modal('show');</script>";
}
?>

@endsection