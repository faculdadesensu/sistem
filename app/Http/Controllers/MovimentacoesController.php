<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;

class MovimentacoesController extends Controller
{
    public function index(){
        $itens = Movimentacao::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.movimentacoes.index', ['itens' => $itens]);
    }

    public function indexMovimentacoes(Request $request){
               
        if ($request->status == 'Entrada' or $request->status == 'Saida') {
            if($request->recepcionista != 'todos2'){
                $itens1 = Movimentacao::where('recep', '=', $request->recepcionista)->where('tipo', '=', $request->status)->where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
            }else{
                $itens1 = Movimentacao::where('tipo', '=', $request->status)->where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
            }
        } else {
            if ($request->recepcionista != 'todos2') {
                $itens1 = Movimentacao::where('tipo', '=', $request->status)->where('recep', '=', $request->recepcionista)->where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
            }
            $itens1 = Movimentacao::where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
        }

        return view('painel-admin.movimentacoes.index', [
    
            'itens' => $itens1, 
            'dataInicial' => $request->dataInicial, 
            'dataFinal' => $request->dataFinal, 
            'atendente' => $request->recepcionista
                
        ]);
    }
}
