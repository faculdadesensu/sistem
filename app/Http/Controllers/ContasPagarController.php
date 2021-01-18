<?php

namespace App\Http\Controllers;

use App\Models\ContasPagares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
@session_start();

class ContasPagarController extends Controller
{
    public function create(){
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.cliente.create');
        }else{
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


        $user_session =  $_SESSION['level_user'];

        $tabela->save();

        
        if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == ''){ 
            move_uploaded_file($imagem_temp, $caminho);
            }else{
                echo 'Extensão de Imagem não permitida!';
                exit();
        }
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('clientes.index');
        }else{
            return redirect()->route('pagar.index');
        }
    }
    
    public function delete(ContasPagares $item){
        $item->delete();
        return redirect()->route('pagar.index');
     }

    public function modal($id){
        $itens = ContasPagares::orderby('data_venc', 'asc')->paginate();
        return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens, 'id' => $id]);
    }

    public function index(){
        $itens = ContasPagares::orderby('data_venc', 'asc')->paginate();
        return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens]);
    }

    public function baixa(Request $request){
        
        $tabela = ContasPagares::find($request->id);

        $tabela->status = 'Pago';
        $tabela->resp_baixa = $_SESSION['name_user'];
        $tabela->data_baixa = date('Y-m-d');

        $tabela->save();

        $itens = ContasPagares::orderby('data_venc', 'asc')->paginate();
        
        return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens]);
    }

    public function modal_baixa($id2){
        $itens = ContasPagares::orderby('data_venc', 'asc')->paginate();
        return view('painel-recepcao.caixa.contas-pagar.index', ['itens' => $itens, 'id2' => $id2]);
    }
}