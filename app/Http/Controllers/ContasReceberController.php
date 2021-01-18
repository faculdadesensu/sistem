<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContasReceberes;
use Illuminate\Support\Facades\DB;

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

        DB::update('update contas_receberes set status_pagamento = "Sim" where id =' . $request->id . '');

        $tabela = ContasReceberes::find($request->id);

        $tabela->status_pagamento = 'Sim';
        $tabela->data_pagamento = date('Y-m-d');

        $tabela->save();
        
        
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens]);
    }

    public function modal_baixa($id2){
        $itens = ContasReceberes::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id2' => $id2]);
    }
}