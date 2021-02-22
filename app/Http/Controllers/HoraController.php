<?php

namespace App\Http\Controllers;

use App\Models\Hora;
use Illuminate\Http\Request;

class HoraController extends Controller
{
    public function index(){
        $hora = Hora::orderby('hora', 'asc')->paginate();
        return view('painel-admin.hora.index', ['hora' => $hora]);
    }
    
    public function create(){
        return view('painel-admin.hora.create');
    }

    public function insert(Request $request){
     
        $hora               = new Hora();
       
        $hora->hora  = $request->hora;

        $check = Hora::where('hora', '=', $request->hora)->count();
    
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um serviço informado!') </script>";
            return view('painel-admin.hora.create');
        }

        $hora->save();
        return redirect()->route('hora.index');
    }

    public function edit(Hora $item){
       
        return view('painel-admin.hora.edit', ['item' => $item]);   
     }
  
     public function editar(Request $request, Hora $item){

        $item->hora      = $request->hora;
        $old             = $request->old;

        if($old != $request->description){
            $check = Hora::where('hora', '=', $request->description)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Descrição de serviço já foi cadastrado!') </script>";
                return view('painel-admin.hora.edit', ['item' => $item]);  
            }
        }

        $item->save();
        
        return redirect()->route('hora.index');
 
     }

     public function delete(Hora $item){
        $item->delete();
        return redirect()->route('hora.index');
     }

     public function modal($id){
        $hora = Hora::orderby('hora', 'asc')->paginate();
        return view('painel-admin.hora.index', ['hora' => $hora, 'id' => $id]);

     }
}
