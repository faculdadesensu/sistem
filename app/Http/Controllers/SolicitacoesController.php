<?php

namespace App\Http\Controllers;

use App\Models\ContasPagares;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
session_start();

class SolicitacoesController extends Controller
{
    public function index(){

        $atendente = $_SESSION['name_user'];
        $solicitacoes = Solicitacao::where('atendente', '=', $atendente)->orderby('id', 'desc')->paginate();
        return view('painel-atend.solicitacoes.index', ['solicitacoes' => $solicitacoes]);
    }
    
    public function create(){
        return view('painel-atend.solicitacoes.create');
    }

    public function insert(Request $request){

        $value = implode('.', explode(',', $request->value));
     
        $tabela  = new Solicitacao();
       
        $tabela->descricao        = $request->descricao;
        $tabela->atendente        = $request->atendente;
        $tabela->value            = $value;
        $tabela->status           = false;
        $tabela->data             = date('Y-m-d');

        $tabela->save();
          
        $tabela2              = new ContasPagares();
        $tabela2->data_venc        = date('Y-m-d');
        $tabela2->descricao        = $request->descricao;
        $tabela2->value            = $value;
        $tabela2->resp_cad         = $request->atendente;
        $tabela2->status           = 'Não Pago';
        $tabela2->servico          = $tabela->id;
  
        $tabela2->save();
        
        
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

        $tabela = ContasPagares::where('servico', '=', $item->id)->first();

        $tabela->data_venc        = date('Y-m-d');
        $tabela->descricao        = $request->descricao;
        $tabela->value            = $value;
        $tabela->resp_cad         = $request->atendente;
        $tabela->status           = 'Não Pago';

        $tabela->save();

        return redirect()->route('solicitacoes.index');
    }

    public function delete(Solicitacao $item){
        $tabela = ContasPagares::where('servico', '=', $item->id)->first();

        $tabela->delete();
        $item->delete();
        return redirect()->route('solicitacoes.index');
    }

    public function modal($id){
        $solicitacoes = Solicitacao::orderby('id', 'desc')->paginate();
        return view('painel-atend.solicitacoes.index', ['solicitacoes' => $solicitacoes, 'id' => $id]);
    }
}