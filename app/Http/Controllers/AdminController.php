<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('painel-admin.index');
    }

    public function edit(Request $request, User $user){
        $user->name = $request->name;
        $user->cpf = $request->cpf;
        $user->user = $request->user;
        $user->password = $request->password;
        $user->save();
        return redirect()->route('admin.index');
    }
}
