<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Atendente;
use App\Models\cliente;
use App\Models\ContasReceberes;
use App\Models\File;
use App\Models\Hora;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

@session_start();

class AgendaController extends Controller
{

    public function index(){                
        $agenda = Agenda::where('status_baixa', '=', 0)->orderby('id', 'desc')->get();
        $agenda_hora = Hora::orderby('hora', 'asc')->get();

        $atendentes = Atendente::where('status', '=', 1)->get();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes]);
        }else{
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
        }
    }
    
    public function create($item, $item2){
        return view('painel-atend.agenda.create', ['hora' => $item, 'data' => $item2]);
    }

    public function createRecep($item, $item2, $item3){

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.create',['hora' =>$item, 'data'=>$item2, 'atendente'=>$item3]);
        }if ($user_session == 'recep') {
            return view('painel-recepcao.agenda.create',['hora' =>$item, 'data'=>$item2, 'atendente'=>$item3]);
        }else{
            return view('painel-recepcao.agenda.create');
        }
    }
    
    public function insert(Request $request){

        $user_session =  $_SESSION['level_user'];
        $value        = implode('.', explode(',', $request->value_service));
        $fila         = new FilaController();
        $agenda       = new Agenda();
        $id_atend     = File::all();
        $atendentes   = Atendente::where('status', '=', 1)->get();
        $create_by    = User::where('name', '=', $_SESSION['name_user'])->first();
        $name_client  = Cliente::where('name','=', $request->name_client)->first();
        $description  = Service::where('description','=', $request->description)->first();
        $id_user      = Atendente::where('name', '=', $request->atendente )->first();
        $agenda_hora  = Hora::orderby('hora', 'asc')->get();

        date_default_timezone_set('America/Sao_Paulo');
        $hora_atual = date('H:i');

        if($hora_atual > $request->time){
            echo "<script language='javascript'> window.alert('Você não pode fazer um agendamento retroativo!') </script>";
             if ($user_session == 'admin') {
                return view('painel-admin.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes]);
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes]);
            }else{
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
            }
        }
       
        $fila_id = [];

        foreach ($id_atend  as $val) {
            $fila_id []= $val->id_user;
        }

        $name_client2 = Cliente::where('id', '=', 1)->first();
        
        if($request->name_client == $name_client2->name){

            echo "<script language='javascript'> window.alert('Selecione um cliente!') </script>";
          
            //Redirecionamento para as views pertinentes ao usuário logado
            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create',  ['atendente' => $request->atendente, 'hora' =>  $request->time, 'data' => $request->date ]);
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.create',  ['atendente' => $request->atendente, 'hora' =>  $request->time, 'data' => $request->date]);
            }else{
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
            }
        }

        $service = Service::where('id', '=', 2)->first();
        
        if($request->description == $service->description){
            echo "<script language='javascript'> window.alert('Selecione um serviço!') </script>";
            $user_session =  $_SESSION['level_user'];

            //Redirecionamento para as views pertinentes ao usuário logado
            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create',   ['atendente' => $request->atendente, 'hora' =>  $request->time, 'data' => $request->date ]);
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.create',   ['atendente' => $request->atendente, 'hora' =>  $request->time, 'data' => $request->date ]);
            }else{
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
            }
        }
       
        $agenda->data           = $request->date;
        $agenda->time           = $request->time;
        $agenda->name_client    = $name_client->id;
        $agenda->fone_client    = $request->fone_client;
        $agenda->create_by      = $create_by->id;
        $agenda->description    = $description->id;
        $agenda->value_service  = $value;
       
        $agenda->atendente = $id_user->id;
   
        //Fila
        /*if(0 == 1){
            $id_fila = $fila->index();

            $atendente = Atendente::where('id', '=', $id_fila)->first();
            $agenda->atendente      = $atendente->name;
            $atendente = $atendente->name;
      
           
            $check2 = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('status_baixa', '=', 0)->get();
            
            $arrayLista = [];
            $arrayID = [];
            
            foreach ($check2 as $v) {
                $arrayLista [] = $v->atendente;    
            }

            foreach ($arrayLista as $v1) {
                $atendenteID = Atendente::where('name','=', $v1)->first();
                $arrayID [] = $atendenteID->id;
            }
           
            if(count($arrayID) == count($fila_id)){

                echo "<script language='javascript'> window.alert('Não tem disponibilidade de agenda para este horário informado! Todos atendentes estão indisponíveis.') </script>";
        
                if ($user_session == 'admin') {
                    return view('painel-admin.agenda.create');
                }if($user_session == 'recep'){
                    return view('painel-recepcao.agenda.create');
                }
            }

            $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('atendente', '=', $atendente)->where('status_baixa', '=', 0)->first();
            if(isset($check)){
                $atend = $atendente;
                for ($i=0; $i < count($fila_id); $i++) {
                   
                    $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('atendente', '=', $atend)->where('status_baixa', '=', 0)->first();
                   
                    if(isset($check)){
                        
                        $id_fila2 = $fila->index();
                        
                        $atendente2 = Atendente::where('id', '=', $id_fila2)->first();

                        $atend2 = $atendente2;
                        $atend = $atend2->name;
                    }
                    if(!in_array($id_fila2, $arrayID)){
                        $agenda->atendente = $atend;
                        $agenda->save();
                        $fila->index();
                        if ($user_session == 'admin') {
                            return view('painel-admin.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
                        }if($user_session == 'recep'){
                            return view('painel-recep.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
                        }
                    }
                }
            }
        }*/

       $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('atendente', '=', $request->atendente)->where('status_baixa', '=', 0)->count();
       
        if($check > 0){
            
            echo "<script language='javascript'> window.alert('Já existe um serviço agendado para este atendente no horário informado!') </script>";

          
            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create');
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.create');
            }else{
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date]);
            }
        }

        $agenda->save();
        
        /*if($_SESSION['level_user'] != 'atend'){
            $agenda2                 = new ContasReceberes();
        
            $agenda2->date              = $request->date;
            $agenda2->client            = $request->name_client;
            $agenda2->atendente         = $request->atendente;
            $agenda2->descricao         = $request->description;
            $agenda2->value             = $value;
            $agenda2->status_pagamento  = 'Não';
            $agenda2->id_agenda         = $agenda->id;
    
            $agenda2->save();
        }*/

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date, 'atendentes' =>$atendentes]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->date, 'atendentes' =>$atendentes]);
        }else{
            
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

    /*public function editar(Request $request, Agenda $item){

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
    }*/

    public function delete(Agenda $item, $data){
        
        $agenda_hora = Hora::orderby('hora', 'asc')->get();
        $atendentes = Atendente::where('status', '=', 1)->get();

        if ($_SESSION['level_user'] == 'atend') {
            $contaReceber = ContasReceberes::where('id_agenda', '=', $item->id);
            $contaReceber->delete();
        }
        

        $item->delete();

        if ($_SESSION['level_user'] == 'admin') {
            return view('painel-admin.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $data, 'atendentes' => $atendentes]);
        }if($_SESSION['level_user'] == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $data, 'atendentes' => $atendentes]);
        }else{
           
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $data]);
        }
    }

    public function modal($id, $data){
        $agenda = Agenda::orderby('id', 'desc')->get();
        $atendentes = Atendente::where('status', '=', 1)->get();
        $agenda_hora = Hora::orderby('hora', 'asc')->get();
      
        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'id' => $id, 'data' => $data, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'id' => $id, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes, 'data' => $data]);
        }else{
           
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'id' => $id, 'data' => $data]);
        }
    }

  
    public function cobrar(Request $request){
   
        $tabela               = new ContasReceberes();
        $atendentes = Atendente::get();
        $agenda_hora = Hora::orderby('hora', 'asc')->get();
       
      
        $tabela->descricao          = $request->descricao;
    
        $tabela->value              = $request->value_service;
        $tabela->client             = $request->name_client;
        $tabela->status_pagamento   = 'Não';
        $tabela->date               = date('Y-m-d');
        $tabela->atendente          = $request->atendente;
        $tabela->id_agenda          = $request->id_agenda;      
             
        $tabela->save();
        
        DB::update('update agendas set status_baixa = 1 where id = '.$request->id_agenda);
        $agenda = Agenda::where('status_baixa', '=', 0)->orderby('id', 'desc')->paginate();

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {

            return redirect()->route('agendas.index');
        }else if ($user_session == 'recep'){

            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'atendentes' => $atendentes, 'data' => $request->date]);
        }else {
           
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
        }
    }

    public function modal_cobrar($item){
        //dd($item);

        $agenda = Agenda::where('status_baixa', '=', 0)->orderby('id', 'desc')->paginate();
        $atendentes = Atendente::get();
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
        $atendentes = Atendente::get();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'data' => $request->data, 'atendentes' => $atendentes]);
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'agenda_hora' => $agenda_hora, 'data' => $request->data, 'atendentes' => $atendentes]);
        }else{
            return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora, 'data' => $request->data]);
        }
    }
}
