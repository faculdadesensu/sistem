<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function index(){
       
        $id = [];
        $idFila = [];

        $file = File::get();

        foreach ($file as $value) {
           $id [] = $value->id_user;
           $id_fila [] = $value->id;
        }
        array_push($id);

        $ini = $id[0];

        array_shift($id);

        $id [] = $ini;
        
        for ($i=0; $i < count($id_fila); $i++) { 
            $update = File::where('id','=', $id_fila[$i])->first();
            $update->id_user = $id[$i];
            $update->save();
        }

        return  $ini;
    }
}
