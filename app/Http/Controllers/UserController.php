<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public function login(Request $request){
       
        $user       = $request->user;
        $password   = $request->password;

        $users      = User::where('user', '=', $user)->orwhere('cpf', '=', $user)->where('password', '=', $password)->first();

        if(@$users->name != null){
  
            @session_start();
            $_SESSION['id_user'] = $users->id;
            $_SESSION['name_user'] = $users->name;
            $_SESSION['level_user'] = $users->level;

            if($_SESSION['level_user'] == 'admin'){
                return view('painel-admin.index');
            }
            if($_SESSION['level_user'] == 'recep'){
                return view('painel-recepcao.index');
            }
            if($_SESSION['level_user'] == 'atend'){
                return view('painel-atend.index');
            }
        }else{
            echo "<script language='javascript'> window.alert('Dados Incorretos!') </script>";
            return view('index');
        }
    }
    
    public function logout(){
       @session_start();
       @session_destroy();
       return view('index');
    }

    public function delete(User $item){
        $item->delete();
        return redirect()->route('users.index');
     }

    public function modal($id){
        $users = User::orderby('id', 'desc')->paginate();
        return view('painel-admin.user.index', ['users' => $users, 'id' => $id]);
    }

    public function index(){
        $users = User::orderby('id', 'desc')->paginate();
        return view('painel-admin.user.index', ['users' => $users]);
    }


    public function recuperar(request $request){
        $usuario = User::where('user', '=', $request->email)->first();
        
        if(!isset($usuario->id)){
            echo "<script language='javascript'> window.alert('Email não Cadastrado!') </script>";
               
        }else{
            //ENVIAR A SENHA PARA O EMAIL
            $to = $usuario->usuario;
			$subject = 'Recuperação de Senha - Nome do estabelecimento ';

			$message = "

			Olá $usuario->name!! 
			<br><br> Sua senha é <b>$usuario->password </b>
			
			";

			$dest = $request->email_adm;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8;' . "\r\n";
			$headers .= "From: " .$dest;
			@mail($to, $subject, $message, $headers);

            echo "<script language='javascript'> window.alert('Senha Enviada para o Email') </script>";

        }
        return view('index');
     }
}
