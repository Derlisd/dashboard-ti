<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidacionPerfilController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OperationController extends Controller
{
    public function getOperacion(Request $request)
    {
        Log::info('recibido : '. json_encode($request->all()));

        $customQuery    = $request->input('campo_query');
        $modulo         = $request->input('modulo');
        $resul          = ['status' => true,'message' => '','error' => '','operador' => ''];
        $operacion      = false;
        $validateController = new ValidacionPerfilController();

        // validar la operacion
        $validate        = $validateController->validateQuery($customQuery);
        $operador   =  $validate['operador'];
        $resul['operador'] = $operador;
        if(empty($operador)){
            $resul['status'] = false;
            $resul['message'] = 'No se encontro un operador válido';
        }
        if($operador !== 'select'){
            Log::info('Es diferente de select : ' . $validate['authorized']);
            if($validate['authorized'] == 'false'){
                Log::info('No puede ejecutar la operacion por falta de permisos');
                $resul['status']    = false;
                $resul['message']   = 'No tiene permisos para ejecutar la operación';
            }

        }
        if($resul['status'] == true){
            Log::info('ejecutando operaciones');
            $operacion = $this->executeOperacion($operador,$customQuery,$modulo);
            return response()->json( $operacion,200);

        }
        return response()->json($resul,200);
    }

    public function executeOperacion($operador, $customQuery,$modulo){
        $resul          = ['status' => true,'message' => 'Operación ejecutada correctamente','error' => '','operador' => ''];
        Log::info('modulo : '. $modulo);
        // envio a la api de auditoria
        $data_auditoria['date']          = Carbon::now()->toDateString();
        $data_auditoria['user']          = Auth::user()->name;
        $data_auditoria['module']        = $modulo;
        $data_auditoria['origin']        = 'Dashboard';
        $data_auditoria['company_id']    ='9999999';
        $data_auditoria['approvedBy']    = '';

        $api            = new ApiController();
        try {
            if($operador == 'select'){
                Log::info('ejecutando select');
                $query = DB::connection('mysql_2')->select($customQuery);
                $data_auditoria['data'] = ['query' => $customQuery, 'result'=> $resul['message']];
            }elseif($operador == 'update'){
                Log::info('ejecutando update : '.$customQuery);
                $query = DB::connection('mysql_2')->update($customQuery);
                if($query < 0){
                    Log::info('No se pudo modificar');
                    $resul['message'] = 'No se encontro registro a modificar';
                    $resul['status']  = false;
                }
                $data_auditoria['data'] = ['query' => $customQuery, 'result'=> $resul['message']];
            }elseif($operador == 'delete'){
                Log::info('ejecutando delete: '.$customQuery);
                $query = DB::connection('mysql_2')->delete($customQuery);
                if($query < 0){
                    Log::info('No se pudo eliminar');
                    $resul['message'] = 'No se encontro registro a eliminar';
                    $resul['status']  = false;
                }
                $data_auditoria['data'] = ['query' => $customQuery, 'result'=> $resul['message']];

            }elseif($operador == 'insert'){
                Log::info('ejecutando insert: '.$customQuery);
                $query = DB::connection('mysql_2')->insert($customQuery);
                if($query < 0){
                    Log::info('No se pudo insertar');
                    $resul['message'] = 'No se pudo insertar';
                    $resul['status']  = false;
                }
                $data_auditoria['data'] = ['query' => $customQuery, 'result'=> $resul['message']];

            }else{
                Log::info('operador invalido');
                return response()->json(['status' => false, 'message' => 'No se pudo validar la consulta, favor verifique la sintaxis si es correcta','data'=>[]]);
            }
            $api->sendAuditData($data_auditoria);
            return $resul;
        } catch (\Throwable $th) {
            Log::error('error : '.$th->getMessage());
            return response()->json(['statuc' => false,'message' => $th->getMessage()]);
        }
    }
}
