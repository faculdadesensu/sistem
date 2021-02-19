<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\Comissoe;
use Illuminate\Http\Request;
session_start();

class ComissaoController extends Controller
{
    public function index(){
        $atendente = Atendente::where('name', '=', $_SESSION['name_user'])->first();
           
        $itens = Comissoe::where('atendente', '=', $atendente->id)->orderby('id', 'desc')->get();
      
        return view('painel-atend.comissao.index', ['itens' => $itens]);
    }

    public function adminComissoes(Request $request){

        $itens = Comissoe::where('atendente', '=', $request->atendente)->where('data', '>=', $request->dataInicial)->where('data', '<=', $request->dataFinal)->orderby('id', 'desc')->get();
        
        return view('painel-admin.comissoes.index', [
                
            'itens' => $itens, 
            'dataInicial' => $request->dataInicial, 
            'dataFinal' => $request->dataFinal, 
            'atendente' => $request->atendente
                
        ]);
    }
}