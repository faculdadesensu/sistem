<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index(){
        $itens = Movimentacao::orderby('id', 'desc')->paginate();
        return view('painel-recepcao.caixa.rel.rel_mov', ['itens' => $itens]);
    }
}
