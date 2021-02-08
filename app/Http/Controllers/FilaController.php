<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\File;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function index(){
        $id_users = Atendente::get();

        $id = [];

        $file = File::get();

        foreach ($file as $value) {
           $id [] = $value->id_user;
        }

      
        
        foreach ($id_users as $value2) {

            if (!in_array($value2->id ,$id)) { 
              
                $tabela = new File();
            
                $tabela->id_user = $value2->id;
    
                $tabela->save();
            }
           
        }
        dd('aqui');
     
                
    }

    public function fila(){

        array_push($id);

        print_r($id);
   
        array_shift($id);
        
        print_r($id); 
    }
}
