<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Atendente;
use App\Models\ContasReceberes;
use App\Models\Hora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

@session_start();

class AgendaController extends Controller
{

    public function index(){                
        $agenda = Agenda::where('status_baixa', '=', 0)->orderby('id', 'desc')->paginate();
        $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda]);
        }else{
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
        }
    }
    
    public function create($item, $item2){

        return view('painel-atend.agenda.create', ['hora' => $item, 'data' => $item2]);
    }

    public function createRecep(){

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.create');
        }else{
            return view('painel-recepcao.agenda.create');
        }
    }
    
    public function insert(Request $request){

        $user_session =  $_SESSION['level_user'];
        $value = implode('.', explode(',', $request->value_service));
        $fila       = new FilaController();
        $agenda     = new Agenda();

        $agenda->data           = $request->date;
        $agenda->time           = $request->time;
        $agenda->name_client    = $request->name_client;
        $agenda->fone_client    = $request->fone_client;
        $agenda->create_by      = $request->create_by;
        $agenda->description    = $request->description;
        $agenda->value_service  = $value;
        

        $id_fila = $fila->index();

        $atendente = Atendente::where('id', '=', $id_fila)->first();
       
        if ($_SESSION['level_user'] == 'atend') {
            $agenda->atendente = $request->atendente;
        }else{
            $agenda->atendente      = $atendente->name;
        }

        $id_atendimento =  DB::select('select id_user from files');
        $atend [] = $atendente->name;
        for ($i=0; $i < count($id_atendimento); $i++) {
            $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('atendente', '=', ($_SESSION['level_user'] == 'atend') ? $request->atendente : $atend [0])->where('status_baixa', '=', 0)->count();
            if($check == 0){
                $id = $fila->index();
                $atend [] = DB::select('select name from atendentes where id = '.$id);
               // echo $atend[0];
            }else{
                $agenda->atendente      = $atend[0];
                echo   $agenda->atendente;
                break;
            }

           
        }

        dd('fora do for');  
       
       /* if($check->atendente != null){
            if($check->atendente == $atendente->name){
                if ($user_session == 'admin') {
                    return view('painel-admin.agenda.create', ['create_by'=>$request->create_by, 'description'=>$request->description, 'value_service'=>$request->value_service, 'atendente' => $atendente->name, 'id'=>$id_fila, 'date2'=>$request->date, 'time2'=>$request->time, 'name_client' =>$request->name_client, 'fone_client'=>$request->fone_client]);
                }if($user_session == 'recep'){
                    return view('painel-recepcao.agenda.create', ['create_by'=>$request->create_by, 'description'=>$request->description, 'value_service'=>$request->value_service,'atendente' => $atendente->name, 'id'=>$id_fila, 'date2'=>$request->date, 'time2'=>$request->time, 'name_client' =>$request->name_client, 'fone_client'=>$request->fone_client]);
                }else{
                    echo "<script language='javascript'> window.alert('Já existe um serviço agendado para este atendente no horário informado 2!') </script>";
                    $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
                    return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
                }
            }
            echo "<script language='javascript'> window.alert('Já existe um serviço agendado para este atendente no horário informado!') </script>";
          
           
            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create');
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.create');
            }else{
                $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
            }
        }*/

        $agenda->save();

        if($_SESSION['level_user'] != 'atend'){
            $agenda2                 = new ContasReceberes();
        
            $agenda2->date              = $request->date;
            $agenda2->client            = $request->name_client;
            $agenda2->atendente         = $request->atendente;
            $agenda2->descricao         = $request->description;
            $agenda2->value             = $value;
            $agenda2->status_pagamento  = 'Não';
            $agenda2->id_agenda         = $agenda->id;
    
            $agenda2->save();
        }

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('agendas.index');
        }if($user_session == 'recep'){
            return redirect()->route('painel-recepcao-agendas.index');
        }else{
            $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
        }
    }

    public function edit(Agenda $item){   
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.edit', ['item' => $item]);
        }else{
            return view('painel-recepcao.agenda.edit', ['item' => $item]);
        }
    }

    public function editar(Request $request, Agenda $item){

        $item->data             = $request->date;
        $item->time             = $request->time;
        $item->name_client      = $request->name_client;
        $item->fone_client      = $request->fone_client;
        $item->atendente        = $request->atendente;
        $item->create_by        = $request->create_by;
        $item->description      = $request->description;
        $item->value_service    = $request->value_service;
        $old                    = $request->old;

        if($old != $request->description){
            $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->count();
            if($check > 0){
                echo "<script language='javascript'> window.alert('Descrição de serviço já foi cadastrado!') </script>";
                $user_session =  $_SESSION['level_user'];

                //Redirecionamento para as views pertinentes ao usuário logado
                if ($user_session == 'admin') {
                    return view('painel-admin.agenda.edit', ['item' => $item]);
                }else{
                    return view('painel-recepcao.agenda.edit', ['item' => $item]);
                }
            }
        }

        $item->save();

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('agendas.index');
        }else{
            return redirect()->route('painel-recepcao-agendas.index');
        }
    }

    public function delete(Agenda $item, $data){
        
        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if($user_session == 'atend'){
            $contaReceber = ContasReceberes::where('id_agenda', '=', $item->id);
            $contaReceber->delete();
        }

        $item->delete();

        if ($user_session == 'admin') {
            return redirect()->route('agendas.index');
        }if($user_session == 'recep'){
            return redirect()->route('painel-recepcao-agendas.index');
        }else{
            $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $data]);
        }
    }

    public function modal($id, $data){
        $agenda = Agenda::orderby('id', 'desc')->paginate();
      
        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'id' => $id]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'id' => $id]);
        }else{
            $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'id' => $id, 'data' => $data]);
        }
    }

  
    public function cobrar(Request $request){
   
        $tabela               = new ContasReceberes();
      
        $tabela->descricao          = $request->descricao;
    
        $tabela->value              = $request->value_service;
        $tabela->client             = $request->name_client;
        $tabela->responsavel_receb  = $_SESSION['name_user'];
        $tabela->status_pagamento   = 'Não';
        $tabela->date               = date('Y-m-d');
        $tabela->atendente          = $request->atendente;
        $tabela->id_agenda          = $request->id_agenda;      
             
        $tabela->save();
        
        DB::update('update agendas set status_baixa = 1 where id = '.$request->id_agenda);

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {

            return redirect()->route('agendas.index');
        }else if ($user_session == 'recep'){

            return redirect()->route('painel-recepcao-agendas.index');
        }else {
            $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
        }
    }

    public function modal_cobrar($item){
        //dd($item);

        $agenda = Agenda::where('status_baixa', '=', 0)->orderby('id', 'desc')->paginate();

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'id2' => $item]);
        }else{
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'id2' => $item]);
        }
    }

    public function busca(Request $request){
        $agenda = Agenda::orderby('id', 'desc')->paginate();
        $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda]);
        }else{
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->data]);
        }
    }
}
