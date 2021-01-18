<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContasReceberes;
use App\Models\Movimentacao;

session_start();

class ContasReceberController extends Controller
{
    
    public function delete(ContasReceberes $item){
        $item->delete();
        return redirect()->route('contas-receber.index');
     }

    public function modal($id){
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id' => $id]);
    }

    public function index(){
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens]);
    }

    public function baixa(Request $request){
        
        $tabela  = ContasReceberes::find($request->id);

        $tabela2 =  new Movimentacao;

        $tabela2->tipo = 'Entrada';
        $tabela2->recep = $_SESSION['name_user'];
        $tabela2->data = date('Y-m-d');
        $tabela2->value = $tabela->value;
        $tabela2->descricao = $tabela->descricao;

        $tabela->status_pagamento = 'Sim';
        $tabela->data_pagamento = date('Y-m-d');

        $tabela2->save();
        $tabela->save();
        
        
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens]);
    }

    public function modal_baixa($id2){
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id2' => $id2]);
    }
}