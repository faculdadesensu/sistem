<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

@session_start();

class ClientController extends Controller
{
    public function index(){
        $cliente = Cliente::orderby('id', 'desc')->paginate();
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.cliente.index', ['cliente' => $cliente]);
        }else{
            return view('painel-recepcao.cliente.index', ['cliente' => $cliente]);
        }
    }
    
    public function create(){
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.cliente.create');
        }else{
            return view('painel-recepcao.cliente.create');
        }
    }

    public function insert(Request $request){
     
        $cliente              = new Cliente();
       
        $cliente->name        = $request->name;
        $cliente->fone        = $request->fone;

        $check = Cliente::where('name', '=', $request->name)->orwhere('fone', '=', $request->fone)->count();
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um cliente com o Nome ou Telefone informado!') </script>";
            $user_session =  $_SESSION['level_user'];

            if ($user_session == 'admin') {
                return view('painel-admin.cliente.create');
            }else{
                return view('painel-recepcao.cliente.create');
            }
        }

        $cliente->save();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('clientes.index');
        }else{
            return redirect()->route('painel-recepcao-clientes.index');
        }
    }

    public function edit(Cliente $item){
       
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.cliente.edit', ['item' => $item]);
        }else{
            return view('painel-recepcao.cliente.edit', ['item' => $item]);
        }  
    }

    public function editar(Request $request, Cliente $item){

        $item->name     = $request->name;
        $item->fone     = $request->fone;
        $oldName        = $request->oldName;
        $oldFone        = $request->oldFone;

        $user_session =  $_SESSION['level_user'];

        if($oldFone != $request->fone){
            $check = Cliente::where('fone', '=', $request->fone)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Cliente já cadastrado. Telefone já cadastrado') </script>";
                if ($user_session == 'admin') {
                    return view('painel-admin.cliente.edit', ['item' => $item]);
                }else{
                    return view('painel-recepcao.cliente.edit', ['item' => $item]);
                } 
            }
        }if ($oldName != $request->name) {
            $check = Cliente::where('name', '=', $request->name)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Cliente já cadastrado. Email já cadastrado!') </script>";                
                
                if ($user_session == 'admin') {
                    return view('painel-admin.cliente.edit', ['item' => $item]);
                }else{
                    return view('painel-recepcao.cliente.edit', ['item' => $item]);
                } 
            }
        }

        $item->save();
        
        if ($user_session == 'admin') {
            return redirect()->route('clientes.index');
        }else{
            return redirect()->route('painel-recepcao-clientes.index');
        }
    }

    public function delete(Cliente $item){
        $item->delete();
        $user_session =  $_SESSION['level_user'];
        if ($user_session == 'admin') {
            return redirect()->route('clientes.index');
        }else{
            return redirect()->route('painel-recepcao-clientes.index');
        }
    }

    public function modal($id){
        $cliente = Cliente::orderby('id', 'desc')->paginate();

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.cliente.index', ['cliente' => $cliente, 'id' => $id]);
        }else{
            return view('painel-recepcao.cliente.index', ['cliente' => $cliente, 'id' => $id]);
        } 
    }
}