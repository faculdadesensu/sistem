<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;

class MovimentacoesController extends Controller
{
    public function index(){
        $itens = Movimentacao::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.movimentacoes.index', ['itens' => $itens]);
    }
}
