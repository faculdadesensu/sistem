<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\Comissoe;
use App\Models\Movimentacao;
use Illuminate\Http\Request;

session_start();

class RelatorioController extends Controller
{
    public function movimentacoes(Request $request){

        $data_inicial = $request->dataInicial;
        $data_final = $request->dataFinal;

        $itens = Movimentacao::where('data', '>=', $data_inicial)->where('data', '<=', $data_final)->get();
        return view('painel-recepcao.caixa.rel.rel_mov', ['itens' => $itens, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final]);
    }

    public function comissoes(Request $request){

        if($_SESSION['level_user'] == 'atend'){

            $data_inicial = $request->dataInicial;
            $data_final = $request->dataFinal;

            $atendente = Atendente::where('name', '=', $_SESSION['name_user'])->first();
    
            $itens = Comissoe::where('data', '>=', $data_inicial)->where('data', '<=', $data_final)->where('atendente', '=', $atendente->id)->get();
            return view('painel-atend.rel.rel_comissao', ['itens' => $itens, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final]);
        }else{
            $data_inicial = $request->dataInicial;
            $data_final = $request->dataFinal;
            $atendente = $request->atendente;
    
            $itens = Comissoe::where('data', '>=', $data_inicial)->where('data', '<=', $data_final)->where('atendente', '=', $atendente)->get();
            return view('painel-admin.rel.rel_comissao', ['itens' => $itens, 'dataInicial' => $data_inicial, 'dataFinal' => $data_final, 'atendente' => $atendente]);
        }
    }
}