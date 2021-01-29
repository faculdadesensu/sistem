<?php

namespace App\Http\Controllers;

use App\Models\Comissoe;

class ComissaoController extends Controller
{
    public function index(){
        session_start();
        $itens = Comissoe::where('atendente', '=', $_SESSION['name_user'])->orderby('id', 'desc')->paginate();
        return view('painel-atend.comissao.index', ['itens' => $itens]);
    }
}