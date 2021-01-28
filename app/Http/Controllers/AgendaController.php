<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ContasReceberes;
use App\Models\Hora;
use Illuminate\Http\Request;
@session_start();

class AgendaController extends Controller
{

    public function index(){                
        $agenda = Agenda::orderby('id', 'desc')->paginate();
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

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.create');
        }if($user_session == 'recep'){
            return view('painel-recepcao.agenda.create');
        }else{
            return view('painel-atend.agenda.create', ['hora' => $item, 'data' => $item2]);
        }
    }

    public function insert(Request $request){
       
        
        $value = implode('.', explode(',', $request->value_service));

        $agenda                 = new Agenda();

        $agenda->data           = $request->date;
        $agenda->time           = $request->time;
        $agenda->name_client    = $request->name_client;
        $agenda->fone_client    = $request->fone_client;
        $agenda->atendente      = $request->atendente;
        $agenda->create_by      = $request->create_by;
        $agenda->description    = $request->description;
        $agenda->value_service  = $value;
       

        $check = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->where('atendente', '=', $request->atendente)->count();
       
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um serviço agendado para este atendente no horário informado!') </script>";
            $user_session =  $_SESSION['level_user'];
           
            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create');
            }if($user_session == 'recep'){
                return view('painel-recepcao.agenda.create');
            }else{
                $agenda_hora = Hora::orderby('hora', 'asc')->paginate();
                return view('painel-atend.agenda.index', ['agenda_hora' => $agenda_hora]);
            }
        }

        $agenda->save();

        $agenda2                 = new ContasReceberes();
        
        $agenda2->date              = $request->date;
        $agenda2->client            = $request->name_client;
        $agenda2->atendente         = $request->atendente;
        $agenda2->descricao         = $request->description;
        $agenda2->value             = $value;
        $agenda2->status_pagamento  = 'Não';
        $agenda2->id_agenda         = $agenda->id;

       
        $agenda2->save();

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
        
        $tabela                     = new ContasReceberes();

        $tabela->descricao          = $request->descricao;
        $tabela->value              = $request->value_service;
        $tabela->client             = $request->name_client;
        $tabela->atendente          = $request->atendente;
        $tabela->responsavel_receb  = $_SESSION['name_user'];
        $tabela->status_pagamento   = 'Não';
        $tabela->date               = date('Y-m-d');

        $tabela->save();

        $delete = Agenda::find($request->id_agenda);
        
        $delete->delete();

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {

            return redirect()->route('agendas.index');
        }else{

            return redirect()->route('painel-recepcao-agendas.index');
        }
    }

    public function modal_cobrar($item){
        //dd($item);

        $agenda = Agenda::orderby('id', 'desc')->paginate();

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
