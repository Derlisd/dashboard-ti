<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ValidacionPerfilController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContactController extends Controller
{
    
    public function get_contacts(Request $request)
    {
       try {
            $customQuery    = request()->input('campo_query');
            $validateController = new ValidacionPerfilController();
            if(!$validateController->validateText($customQuery,'select')){
                $customQuery = 'SELECT * FROM contact limit 100';
            };
            $query = DB::connection('mysql_2')->table('contact');
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
   
    
    public function getContactById($id)
    {
        $contact = Contact::find($id);
        return response()->json($contact,200);
    }

    public function updateContact(Request $request)
    {
       try {
        if(Auth::user()->perfil === 'Desarrollador') return response()->json(['status' => false,'message' => 'No tienes permisos suficientes'],200);
            $api     = new ApiController();
            $data    = [];
            $data_auditoria = [];
           
            $contact = Contact::find($request->input('contactId'));
            $data['old'] = $contact->first();
            $data['new'] = $request->all();
            Log::info('data : '.json_encode($data));

            $update = $contact->update($data['new']);
            if(!$update){
                Log::info('No se pudo actualizar '.$request->input('contactId'));
                return response()->json(['status' => false,'message' => 'No se pudo actualizar'],200);
            }
            
            // envio a la api de auditoria
            $data_auditoria['date']          = Carbon::now()->toDateString();
            $data_auditoria['user']          = Auth::user()->name;
            $data_auditoria['module']        = 'Contact';
            $data_auditoria['origin']        = 'Dashboard';
            $data_auditoria['company_id']    ='9999999';
            $data_auditoria['approvedBy']    = '';
            $data_auditoria['data']          = $data;

            $res = $api->sendAuditData($data_auditoria);
            return response()->json(['status' => true,'message' => 'Actualizado correctamente'],200);
       } catch (\Throwable $th) {
            Log::info('error '. $th->getMessage());
            return response()->json(['status' => false,'message' => 'No se pudo actualizar'],200);

       }
       
    }
}
