<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ValidacionPerfilController extends Controller
{
    public function validateQuery($query){
        $perfil     = Auth::user()->perfil; 
        $resul      = ['operador' => false,'authorized' => 'false'];
        $operations     = array('update', 'delete', 'insert','select');

        foreach ($operations as $operacion) {
            if($this->validateText($query,$operacion)){
                $resul['operador'] = $operacion;
                if($this->validatePerfilPermision($operacion) == 'true'){
                    $resul['authorized'] = 'true';
                }
            }
        }
        return $resul;
    }
    public function validateText($texto,$palabra){
        $posicion = strpos(strtolower($texto),$palabra);
        $resul = false;
        if($posicion !== false){
            Log::info('validateText | se encontro el texto');
            $resul = true;
        }
        return $resul;
    }
    public function validatePerfilPermision($operacion){
        $perfil = Auth::user()->perfil;
        $resul  = 'true';
        if($operacion != 'select'){
            if($perfil != 'Admin'){
                Log::info('No tiene permiso');
                $resul = 'false';
            }
        }
       
        return $resul;
    }

    
}
