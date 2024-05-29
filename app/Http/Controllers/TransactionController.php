<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{

    public function get_transactions(Request $request)
    {
        try {
            $customQuery    = request()->input('campo_query');
            $validateController = new ValidacionPerfilController();
            if(!$validateController->validateText($customQuery,'select')){
                $customQuery = 'SELECT * FROM transaction limit 100';
            };
            $query = DB::connection('mysql_2')->table('transaction');
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
    public function updateTransaction(Request $request)
    {
       try {
        
        if(Auth::user()->perfil === 'Desarrollador') return response()->json(['status' => false,'message' => 'No tienes permisos suficientes'],200);

            $api            = new ApiController();
            $data           = [];
            $data_auditoria = [];
            $transaction    = Transaction::find($request->input('transactionId'));            
            $data['old']    = $transaction;
            $data['new']    = $request->all();
            Log::info('data : '.json_encode($data));
            $update = $transaction->update($request->all());            
            if(!$update) return response()->json(['status' => false,'message' => 'No se pudo actualizar'],200);
            
            // envio a la api de auditoria
            $data_auditoria['date']          = Carbon::now()->toDateString();
            $data_auditoria['user']          = Auth::user()->name;
            $data_auditoria['module']        = 'Transaction';
            $data_auditoria['origin']        = 'Dashboard';
            $data_auditoria['company_id']    ='9999999';
            $data_auditoria['approvedBy']    = '';
            $data_auditoria['data']          = $data;

            $res = $api->sendAuditData($data_auditoria);
            return response()->json(['status' => true,'message' => 'Actualizado correctamente'],200);
       } catch (\Throwable $th) {
            Log::info('updateTransaction error '. $th->getMessage());
            return response()->json(['status' => false,'message' => 'No se pudo actualizar'],200);

       }
       
    }
}
