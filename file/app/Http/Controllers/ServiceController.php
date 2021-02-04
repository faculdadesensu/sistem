<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index(){
        $service = Service::orderby('id', 'desc')->paginate();
        return view('painel-admin.serv.index', ['service' => $service]);
    }

    public function getService(Request $request) 
    {
       $value = $request->value;
    
       $dadosService = DB::table('services')->select('valor')->where('description', $value)->get();
    
      return response()->json($dadosService);
    }

    public function create(){
        return view('painel-admin.serv.create');
    }

    public function insert(Request $request){
     
        $service               = new Service();

        $valor = implode('.', explode(',', $request->valor));
        //$comissao = implode('.', explode(',', $request->comissao));
        $service->valor        = $valor;
        $service->description  = $request->description;
        $service->tipo_comissao  = $request->tipo_comissao;

        if($request->tipo_comissao == 'pct'){

            $service->comissao      = ($valor/100) * $request->comissao;
            $service->qtd_comissao  = $request->comissao;

        }else(
            $service->comissao = $request->comissao
        );
        
        $check = Service::where('description', '=', $request->description)->count();
    
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um serviço informado!') </script>";
            return view('painel-admin.serv.create');
        }

        $service->save();
        return redirect()->route('service.index');
    }

    public function edit(Service $item){
       
        return view('painel-admin.serv.edit', ['item' => $item]);
     }
  
     public function editar(Request $request, Service $item){

        $valor = implode('.', explode(',', $request->valor));

        $item->description      = $request->description;
        $item->valor            = $valor;
        $comissao = implode('.', explode(',', $request->comissao));
        $old                    = $request->old;

        if($request->tipo_comissao == 'pct'){

            $item->comissao = ($valor/100) * $comissao;
            $item->tipo_comissao = 'pct';
            $item->qtd_comissao  = $comissao;

        }else{
            $item->comissao         = $comissao;
            $item->tipo_comissao    = 'vlf';
        };

        if($old != $request->description){
            $check = Service::where('description', '=', $request->description)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Descrição de serviço já foi cadastrado!') </script>";
                return view('painel-admin.serv.edit', ['item' => $item]);  
            }
        }

        $item->save();
        
        return redirect()->route('service.index');
 
     }

     public function delete(Service $item){
        $item->delete();
        return redirect()->route('service.index');
     }

     public function modal($id){
        $service = Service::orderby('id', 'desc')->paginate();
        return view('painel-admin.serv.index', ['service' => $service, 'id' => $id]);

     }

}
