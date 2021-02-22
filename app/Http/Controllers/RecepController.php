<?php

namespace App\Http\Controllers;

use App\Models\Recepcionista;
use App\Models\User;
use Illuminate\Http\Request;

class RecepController extends Controller
{
    public function index(){
        $recepcionista = Recepcionista::orderby('id', 'desc')->paginate();
        return view('painel-admin.recep.index', ['recepcionista' => $recepcionista]);
    }
    
    public function create(){
        return view('painel-admin.recep.create');
    }

    public function insert(Request $request){
     
        $recepcionista              = new Recepcionista();
        $recepcionista2             = new User();
       
        $recepcionista->name        = $request->name;
        $recepcionista->cpf         = $request->cpf;
        $recepcionista->email       = $request->email;
        $recepcionista->endereco    = $request->endereco;
        $recepcionista->fone        = $request->fone;
        $recepcionista2->name       = $request->name;
        $recepcionista2->cpf        = $request->cpf;
        $recepcionista2->user       = $request->email;
        $recepcionista2->password   = '123';
        $recepcionista2->level      = 'recep';

        $check = Recepcionista::where('cpf', '=', $request->cpf)->orwhere('email', '=', $request->email)->count();
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um atendente com o EMAIL ou CPF informado!') </script>";
            return view('painel-admin.recep.create');
        }

        $recepcionista2->save();
        $recepcionista->save();
        return redirect()->route('recep.index');
    }

    public function edit(Recepcionista $item){  
        return view('painel-admin.recep.edit', ['item' => $item]);   
    }

    public function editar(Request $request, Recepcionista $item){

        $item->name     = $request->name;
        $item->cpf      = $request->cpf;
        $item->email    = $request->email;
        $item->endereco = $request->endereco;
        $item->fone     = $request->fone;
        $oldCpf         = $request->oldCpf;
        $oldEmail       = $request->oldEmail;

        if($oldCpf != $request->cpf){
            $check = Recepcionista::where('cpf', '=', $request->cpf)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('CPF já foi cadastrado!') </script>";
                return view('painel-admin.recep.edit', ['item' => $item]);  
            }
        }if ($oldEmail != $request->email) {
            $check = Recepcionista::where('email', '=', $request->email)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Email já cadastrado!') </script>";                
                return view('painel-admin.recep.edit', ['item' => $item]);  
            }
        }

        $user = User::where('cpf', '=', $request->oldCpf)->first();
      
        $user->name       = $request->name;
        $user->cpf        = $request->cpf;
        $user->user       = $request->email;        

        $user->save();
        $item->save();
        
        return redirect()->route('recep.index');
     }

    public function delete(Recepcionista $item){
        $user = User::where('cpf', '=', $item->cpf);

        $user->delete();
        $item->delete();
        return redirect()->route('recep.index');
    }

    public function modal($id){
        $recepcionista = Recepcionista::orderby('id', 'desc')->get();
        return view('painel-admin.recep.index', ['recepcionista' => $recepcionista, 'id' => $id]);
    }
}