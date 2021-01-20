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
     
        $tabela                   = new Solicitacao();
       
        $tabela->descricao        = $request->descricao;
        $tabela->atendente        = $request->atendente;
        $tabela->value            = $request->value;
        $tabela->data             = date('Y-m-d');

        $check = Solicitacao::where('name', '=', $request->name)->orwhere('fone', '=', $request->fone)->count();
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um cliente com o Nome ou Telefone informado!') </script>";
            return view('painel-atend.solicitacoes.create');
        }

        $tabela->save();
        
        return redirect()->route('solicitacoes.index');
    }

    public function edit(Solicitacao $item){
        return view('painel-atend.solicitacoes.edit', ['item' => $item]); 
    }

    public function editar(Request $request, Solicitacao $item){

        $item->descricao        = $request->descricao;
        $item->atendente        = $request->atendente;
        $item->value            = $request->value;
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
