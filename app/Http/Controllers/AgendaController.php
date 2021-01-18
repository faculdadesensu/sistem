<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\ContasReceberes;
use Illuminate\Http\Request;
@session_start();

class AgendaController extends Controller
{

    public function index(){                
        $agenda = Agenda::orderby('id', 'desc')->paginate();
        
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda]);
        }else{
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda]);
        }
    }
    
    public function create(){

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.create');
        }else{
            return view('painel-recepcao.agenda.create');
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

        $check                  = Agenda::where('data', '=', $request->date)->where('time', '=', $request->time)->count();
    
        if($check > 0){
            echo "<script language='javascript'> window.alert('Já existe um serviço agendado nesse horário informado!') </script>";
            $user_session =  $_SESSION['level_user'];

            if ($user_session == 'admin') {
                return view('painel-admin.agenda.create');
            }else{
                return view('painel-recepcao.agenda.create');
            }
        }

        $agenda->save();

        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('agendas.index');
        }else{
            return redirect()->route('painel-recepcao-agendas.index');
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

    public function delete(Agenda $item){
        $item->delete();

        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return redirect()->route('agendas.index');
        }else{
            return redirect()->route('painel-recepcao-agendas.index');
        }
    }

    public function modal($id){
        $agenda = Agenda::orderby('id', 'desc')->paginate();




        //Redirecionamento para as views pertinentes ao usuário logado
        $user_session =  $_SESSION['level_user'];

        if ($user_session == 'admin') {
            return view('painel-admin.agenda.index', ['agenda' => $agenda, 'id' => $id]);
        }else{
            return view('painel-recepcao.agenda.index', ['agenda' => $agenda, 'id' => $id]);
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
}
