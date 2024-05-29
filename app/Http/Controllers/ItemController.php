<?php

namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class ItemController extends Controller
{
    public function get_items(Request $request)
    {
       try {
            $customQuery    = request()->input('campo_query');
            $validateController = new ValidacionPerfilController();
            if(!$validateController->validateText($customQuery,'select')){
                $customQuery = 'SELECT * FROM item limit 100';
            };
            $query = DB::table('item');
            $resultados = [];
            if(!empty($customQuery)){
                Log::info('ejecutando la consulta : '.$customQuery);
                $resultados = DB::connection('mysql_2')->select($customQuery);
            }
    
            return response()->json($resultados,200);
       } catch (\Throwable $th) {
        Log::error('error : '.$th->getMessage());
        return response()->json(['error' => $th->getMessage()]);
       }
    }
   
    public function updateItem(Request $request)
    {
       try {
            if(Auth::user()->perfil === 'Desarrollador') return response()->json(['status' => false,'message' => 'No tienes permisos suficientes'],200);

            $api     = new ApiController();
            $data    = [];
            $data_auditoria = [];
            $item = Item::find($request->input('itemId'));
            $data['old'] = $item;
            $data['new'] = $request->all();
            Log::info('data : '.json_encode($data));

            $update = $item->update($request->all());
            
            if(!$update) return response()->json(['status' => false,'message' => 'No se pudo actualizar'],200);
            
            // envio a la api de auditoria
            $data_auditoria['date']          = Carbon::now()->toDateString();
            $data_auditoria['user']          = Auth::user()->name;
            $data_auditoria['module']        = 'Item';
            $data_auditoria['origin']        = 'Dashboard';
            $data_auditoria['company_id']    ='9999999';
            $data_auditoria['approvedBy']    = '';
            $data_auditoria['data']          = $data;

            $res = $api->sendAuditData($data_auditoria);
            return response()->json(['status' => true,'message' => 'Actualizado correctamente'],200);
       } catch (\Throwable $th) {
            Log::info('error '. $th->getMessage());
            return response()->json(['status' => false,'message' => 'No se pudo actualizar'],500);

       }
       
    }
}
