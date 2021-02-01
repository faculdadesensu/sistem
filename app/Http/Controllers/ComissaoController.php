<?php

namespace App\Http\Controllers;

use App\Models\Comissoe;
use Illuminate\Http\Request;
session_start();

class ComissaoController extends Controller
{
    public function index(){
     
        $itens = Comissoe::where('atendente', '=', $_SESSION['name_user'])->orderby('id', 'desc')->paginate();
        return view('painel-atend.comissao.index', ['itens' => $itens]);
    }

    public function adminComissoes(Request $request){

        $itens = Comissoe::where('atendente', '=', $request->atendente)->where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
        
        return view('painel-admin.comissoes.index', ['itens' => $itens]);
    }
}