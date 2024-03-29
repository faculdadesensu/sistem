<?php

namespace App\Http\Controllers;

use App\Models\Comissoe;
use Illuminate\Http\Request;
use App\Models\ContasReceberes;
use App\Models\Movimentacao;
use App\Models\Service;
use App\Models\User;

session_start();

class ContasReceberController extends Controller
{
    
    public function delete(ContasReceberes $item){
        $item->delete();

        if($_SESSION['level_user'] == 'admin'){
            return redirect()->route('administrador.contas-receber.index');
        }else{
            return redirect()->route('contas-receber.index');
        }
    }

    public function modal($id){
        $itens = ContasReceberes::orderby('id', 'desc')->where('status_pagamento', '!=', 'Sim')->get();

        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-receber.index', ['itens' => $itens, 'id' => $id]);
        }else{
            return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id' => $id]);
        }
    }

    public function modalPrincipal($id){
        $itens = ContasReceberes::orderby('id', 'desc')->where('status_pagamento', '!=', 'Sim')->get();

        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-receber.index', ['itens' => $itens, 'id3' => $id]);
        }else{
            return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id3' => $id]);
        }
       
    }
    
    public function index(){
        $itens = ContasReceberes::orderby('id', 'desc')->where('status_pagamento', '!=', 'Sim')->get();
        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-receber.index', ['itens' => $itens]);
        }else{
            return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens]);
        }
    }

    public function baixa(Request $request){
      
        $tabela  = ContasReceberes::find($request->id);
        $resp_baixa  = User::where('name', '=', $_SESSION['name_user'])->first();

        $tabela2 =  new Movimentacao;
        $tabela3 = new Comissoe();

        $tabela2->tipo      = 'Entrada';
        $tabela2->recep     = $resp_baixa->id;
        $tabela2->data      = date('Y-m-d');
        $tabela2->value     = $tabela->value;
        $tabela2->descricao = $tabela->descricao;

        $tabela->responsavel_receb  = $resp_baixa->id;
        $tabela->status_pagamento   = 'Sim';
        $tabela->data_pagamento     = date('Y-m-d');

        $tabela2->save();
        $tabela->save();

        $service = Service::where('id', '=', $tabela->descricao)->first();

        $tabela3->descricao     = $tabela->descricao;

        if($service->tipo_comissao == 'pct'){
            
            //verificar o calculo de comissões
            $tabela3->value         = ($tabela->value/100) * $service->qtd_comissao;
            
        }else{
            $tabela3->value         = $service->comissao;
        }

        $tabela3->atendente     = $tabela->atendente;
        $tabela3->data          = date('Y-m-d');

        $tabela3->save();
        
        $itens = ContasReceberes::orderby('id', 'desc')->where('status_pagamento', '!=', 'Sim')->get();

        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-receber.index', ['itens' => $itens]);
        }else{
            return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens]);
        }
    }

    public function modal_baixa($id2){
        $itens = ContasReceberes::orderby('id', 'desc')->where('status_pagamento', '!=', 'Sim')->get();

        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-receber.index', ['itens' => $itens, 'id2' => $id2]);
        }else{
            return view('painel-recepcao.caixa.contas-receber.index', ['itens' => $itens, 'id2' => $id2]);
        }
    }
}