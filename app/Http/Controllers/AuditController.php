<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Log;


class AuditController extends Controller
{
    public function index_audit(Request $request){

        try {
            Log::info('recibido '.json_encode($request->all()));
            $fecha_inicio   = $request->input('fecha_inicio');
            $fecha_fin      = $request->input('fecha_fin');
            $company_id     = $request->input('company_id');
            Log::info("formateado ini: $fecha_inicio fin: $fecha_fin company_id : $company_id");

            $api        = new ApiController();

            $response = $api->getAudiData($fecha_inicio,$fecha_fin,$company_id);

            return json_decode($response);

        } catch (\Throwable $th) {
            Log::error('error : ' . $th->getMessage());
            return $th->getMessage();
        }
    }
}
