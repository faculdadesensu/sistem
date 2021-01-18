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
?>

<a href="{{route('pagar.inserir')}}" type="button" class="mt-2 mb-4 btn btn-primary">Novo Registro</a>
<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        
        <div class="table-responsive">
            <h6 class="mb-4"><i> CONTAS A PAGAR</i></h6><hr>
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Data Vencimento</th>
                        <th>Descrição</th>
                        <th>Responsavel Cadastro</th>
                        <th>Responsavel Baixa</th>
                        <th>Data Pagamento</th>
                        <th>Arquivo</th>
                        <th>Valor</th>
                        <th>Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($itens as $item)
                        <?php 
                            $data = implode('/', array_reverse(explode('-', $item->data_venc)));
                            $data2 = implode('/', array_reverse(explode('-', $item->data_baixa)));
                            $value = implode(',', explode('.', $item->value));
                        ?>
                        @if ($item->status_pagamento != 'Sim')
                            <tr>
                                <td><i class="fas fa-square mr-1 text-success <?php if($item->status != 'Pago'){ ?> text-danger <?php } ?>"></i></td>
                                <td>{{$data}}</td>
                                <td>{{$item->descricao}}</td>
                                <td>{{$item->resp_cad}}</td>
                                <td>
                                    @if ($item->resp_baixa == "")
                                    PENDENTE
                                    @endif
                                    {{$item->resp_baixa}}
                                </td>
                                <td>
                                    @if ($data2 == "")
                                        PENDENTE
                                    @endif
                                    {{$data2}}
                                
                                </td>
                                <td><?php if($item->upload != ''){ ?><a href="{{ URL::asset(''.$item->upload)}}" target="_blank" ><i class="fas fa-square mr-1 text-success" ></i>Arquivo </a><?php } ?></td>
                                <td>R$ {{$value}}</td>
                                @if (@$item->status != 'Pago')
                                    <td>
                                        <a title="Finalizar Recebimento" href="{{route('pagar.modal-baixa', $item->id)}}"><i class="fas fa-coins text-success mr-3"></i></a>
                                        <a title="Excluir Recebimento" href="{{route('pagar.modal', $item)}}"><i class="fas fa-trash text-danger mr-1"></i></a>
                                    </td>
                                @else
                                    <td>Finalizado</td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').dataTable({
            "ordering": false
        })

    });
</script>

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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Baixar Recebimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja realmente finalizar esse recebimento?

            </div>
            <div class="modal-footer">
                
                <form method="POST" action="{{route('pagar.baixa', $id2)}}">
                    @csrf
                    @method('put')
                    <input type="hidden" name='id' value="{{$id2}}">
                    <input type="hidden" name='date' value="{{date('Y-m-d')}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Finalizar Pagamento</button>
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
?>

@endsection