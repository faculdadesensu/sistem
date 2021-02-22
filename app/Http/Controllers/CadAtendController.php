<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\File;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class CadAtendController extends Controller
{
    public function index(){
        $atendentes = Atendente::orderby('id', 'desc')->paginate();
        return view('painel-admin.atend.index', ['atendentes' => $atendentes]);
    }
    
    public function create(){
        return view('painel-admin.atend.create');
    }

    public function insert(Request $request){
     
        $atendente              = new Atendente();
       
        $atendente->name        = $request->name;
        $atendente->cpf         = $request->cpf;
        $atendente->email       = $request->email;
        $atendente->endereco    = $request->endereco;
        $atendente->fone        = $request->fone;

        $descriptionEsp = Service::find(2);
        
        if($request->expec1 == $descriptionEsp->description || $request->expec2 == $descriptionEsp->description){
            echo "<script language='javascript'> window.alert('Selecione as expecializações do(a) atendente!') </script>";
            return view('painel-admin.atend.create');  
        }

        $expec1 = Service::where('description','=', $request->expec1)->first();
        $expec2 = Service::where('description','=', $request->expec2)->first();
        $atendente->expec1      = $expec1->id;
        $atendente->expec2      = $expec2->id;

        $atendente2             = new User();

        $atendente2->name       = $request->name;
        $atendente2->cpf        = $request->cpf;
        $atendente2->user       = $request->email;
        $atendente2->password   = '123';
        $atendente2->level      = 'atend';


        $check = Atendente::where('cpf', '=', $request->cpf)->orwhere('email', '=', $request->email)->count();
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um atendente com o EMAIL ou CPF informado!') </script>";
            return view('painel-admin.atend.create');
        }

        $atendente2->save();
        $atendente->save();

        $fila = new File();
            
        $fila->id_user = $atendente->id;

        $fila->save();

        return redirect()->route('cadAtend');
    }

    public function edit(Atendente $item){       
        return view('painel-admin.atend.edit', ['item' => $item]);   
    }

    public function editar(Request $request, Atendente $item){

        $item->name     = $request->name;
        $item->cpf      = $request->cpf;
        $item->email    = $request->email;
        $item->endereco = $request->endereco;
        $item->fone     = $request->fone;

        $descriptionEsp = Service::find(2);
        
        if($request->expec1 == $descriptionEsp->description || $request->expec2 == $descriptionEsp->description){
            echo "<script language='javascript'> window.alert('Selecione as expecializações do(a) atendente!') </script>";
            return view('painel-admin.atend.edit', ['item' => $item]);  
        }

        $expec1 = Service::where('description','=', $request->expec1)->first();
        $expec2 = Service::where('description','=', $request->expec2)->first();
        $item->expec1      = $expec1->id;
        $item->expec2      = $expec2->id;

        $oldCpf         = $request->oldCpf;
        $oldEmail       = $request->oldEmail;

        if($oldCpf != $request->cpf){
            $check = Atendente::where('cpf', '=', $request->cpf)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('CPF já foi cadastrado!') </script>";
                return view('painel-admin.atend.edit', ['item' => $item]);  
            }
        }if ($oldEmail != $request->email) {
            $check = Atendente::where('email', '=', $request->email)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Email já cadastrado!') </script>";                
                return view('painel-admin.atend.edit', ['item' => $item]);  
            }
        }

        $user = User::where('cpf', '=', $request->oldCpf)->first();
      
        $user->name       = $request->name;
        $user->cpf        = $request->cpf;
        $user->user       = $request->email;        

        $user->save();
        $item->save();
        
        return redirect()->route('cadAtend');
    }

    public function delete(Atendente $item){
     
        $fila = File::where('id_user', '=', $item->id);
        $user = User::where('cpf', '=', $item->cpf);

        $user->delete();
        $fila->delete();
        $item->delete();

        return redirect()->route('cadAtend');
    }

    public function modal($id){
        $atendente = Atendente::orderby('id', 'desc')->get();
        return view('painel-admin.atend.index', ['atendentes' => $atendente, 'id' => $id]);
    }

    public function modal_history($id){
        $atendente = Atendente::orderby('id', 'desc')->get();
        return view('painel-admin.atend.index', ['atendentes' => $atendente, 'id2' => $id]);
    }

}