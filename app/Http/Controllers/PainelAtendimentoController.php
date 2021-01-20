<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PainelAtendimentoController extends Controller
{
    public function index(){
        return view('painel-atend.index');
    }

    public function edit(Request $request, User $user){
        $user->name = $request->name;
        $user->cpf = $request->cpf;
        $user->user = $request->user;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('painel-atend.index');
    }
}
