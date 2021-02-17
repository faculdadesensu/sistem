<?php

namespace App\Http\Controllers;

use App\Models\ContasPagares;
use App\Models\Movimentacao;
use App\Models\Solicitacao;
use Illuminate\Http\Request;

@session_start();

class ContasPagarController extends Controller
{
    public function create(){
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.caixa.contas-pagar.create');
        }else {
            return view('painel-recepcao.caixa.contas-pagar.create');
        }
    }

    public function insert(Request $request){
    
        $tabela              = new ContasPagares();

        //SCRIPT PARA SUBIR FOTO NA PASTA
        $nome_img = preg_replace('/[ -]+/' , '-' , @$_FILES['imagem']['name']);
        $caminho = 'img/upload/'.$nome_img;
        
        if (@$_FILES['imagem']['name'] == ""){
            $imagem = "";
            }else{
            $imagem = $nome_img;
        }

        $imagem_temp = @$_FILES['imagem']['tmp_name']; 

        $ext = pathinfo($imagem, PATHINFO_EXTENSION);

        $value = implode('.', explode(',', $request->value));
       
        $tabela->data_venc        = $request->data_venc;
        $tabela->descricao        = $request->descricao;
        $tabela->value            = $value;
        $tabela->resp_cad         = $request->resp_cad;
        $tabela->status           = 'Não Pago ';
        $tabela->upload           = $imagem;

        $tabela->save();
        
        if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == ''){ 
            move_uploaded_file($imagem_temp, $caminho);
            }else{
                echo 'Extensão de Imagem não permitida!';
                exit();
        }
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('pagar.index');
        }else{
            return redirect()->route('pagar.index');
        }
    }
    
    public function delete(ContasPagares $item){
        $item->delete();
        return redirect()->route('pagar.index');
     }

    public function modal($id){
        $itens = ContasPagares::orderby('id', 'desc')->where('status', '!=', 'Pago')->get();
        $user_session =  $_SESSION['level_user'];
        if ($user_session == 'admin') {
            return view('painel-admin.caixa.contas-pagar.index', ['itens' => $itens, 'id' => $id]);
        }else{
            return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens, 'id' => $id]);
        }
        
    }

    public function index(){

        $itens = ContasPagares::orderby('id', 'desc')->where('status', '!=', 'Pago')->get();
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.caixa.contas-pagar.index', ['itens' => $itens]);
        }else{
            return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens]);
        }
    }

    public function baixa(Request $request){
        
        $tabela = ContasPagares::find($request->id);

        $tabela2 =  new Movimentacao;

        $tabela2->tipo      = 'Saida';
        $tabela2->recep     = $_SESSION['name_user'];
        $tabela2->data      = date('Y-m-d');
        $tabela2->value     = $tabela->value;
        $tabela2->descricao = $tabela->descricao;

        $tabela->status = 'Pago';
        $tabela->resp_baixa = $_SESSION['name_user'];
        $tabela->data_baixa = date('Y-m-d');

        $id = ContasPagares::where('id', '=', $request->id)->first();

        if($id->servico != null){
            $tabela3 = Solicitacao::find($id->servico);
            $tabela3->status    = true;
            $tabela3->save();
        }
              
        $tabela->save();
        $tabela2->save();
        

        $itens =  ContasPagares::orderby('id', 'desc')->where('status', '!=', 'Pago')->get();

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.caixa.contas-pagar.index', ['itens' => $itens]);
        }else{
            return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens]);
        }
    }

    public function modal_baixa($id2){
        $itens =  ContasPagares::orderby('id', 'desc')->where('status', '!=', 'Pago')->get();
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.caixa.contas-pagar.index', ['itens' => $itens, 'id2' => $id2]);
        }else{
            return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens, 'id2' => $id2]);
        }
    }

    
    public function modalPrincipal($id){
        $itens = ContasPagares::orderby('id', 'desc')->where('status', '!=', 'Pago')->get();

        if($_SESSION['level_user'] == 'admin'){
            return view('painel-admin.caixa.contas-pagar.index', ['itens' => $itens, 'id3' => $id]);
        }else{
            return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens, 'id3' => $id]);
        }
       
    }

}