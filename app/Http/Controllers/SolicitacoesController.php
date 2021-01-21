<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;

class SolicitacoesController extends Controller
{
    public function index(){
        $solicitacoes = Solicitacao::orderby('id', 'desc')->paginate();
        return view('painel-atend.solicitacoes.index', ['solicitacoes' => $solicitacoes]);
    }
    
    public function create(){
        return view('painel-atend.solicitacoes.create');
    }

    public function insert(Request $request){

        $value = implode('.', explode(',', $request->value));
     
        $tabela                   = new Solicitacao();
       
        $tabela->descricao        = $request->descricao;
        $tabela->atendente        = $request->atendente;
        $tabela->value            = $value;
        $tabela->status           = false;
        $tabela->data             = date('Y-m-d');

        $tabela->save();
        
        return redirect()->route('solicitacoes.index');
    }

    public function edit(Solicitacao $item){
        return view('painel-atend.solicitacoes.edit', ['item' => $item]); 
    }

    public function editar(Request $request, Solicitacao $item){

        $value = implode('.', explode(',', $request->value));
        
        $item->descricao        = $request->descricao;
        $item->atendente        = $request->atendente;
        $item->value            = $value;
        $item->data             = date('Y-m-d');

        $item->save();
        
        return redirect()->route('solicitacoes.index');
    }

    public function delete(Solicitacao $item){
        $item->delete();
        return redirect()->route('solicitacoes.index');
    }

    public function modal($id){
        $solicitacoes = Solicitacao::orderby('id', 'desc')->paginate();
        return view('painel-atend.solicitacoes.index', ['solicitacoes' => $solicitacoes, 'id' => $id]);
    }
}
