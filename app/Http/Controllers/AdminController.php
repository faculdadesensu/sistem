<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\Recepcionista;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('painel-admin.index');
    }

    public function edit(Request $request, User $user){
        if($user->level == 'atend'){
            $atend = Atendente::where('name', '=', $user->name)->first();
            $atend->name = $request->name;
            $atend->save();
        }else if ($user->level == 'recep'){
            $recep = Recepcionista::where('name', '=', $user->name)->first();
            $recep->name = $request->name;
            $recep->save();
        }
        
        $user->name = $request->name;
        $user->cpf = $request->cpf;
        $user->user = $request->user;
        $user->password = $request->password;
        $user->save();

       
        return redirect()->route('admin.index');
    }
}
