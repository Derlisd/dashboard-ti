<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function getToken(){
      $url          = env('API_AUDITORIA','');
      $usuario      = env('API_USER','');
      $contrasena   = env('API_PASS','');
      $cliente = new Client();

      Log::info('api : '.$url);
      try {
            $response = $cliente->post("$url/api/get-token", [
                'json' => [
                    'email' => $usuario,
                    'password' => $contrasena,
                ]
            ]);
            $data = json_decode($response->getBody(), true);
            return $data['token'];
        } catch (\Throwable $th) {
            Log::error('api error : ' . $th->getMessage());
            return $th->getMessage();
        }
    }
    public function sendAuditData($data){
        $url          = env('API_AUDITORIA','');
        try {
            $token = $this->getToken();
            $cliente = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            // Realizar la solicitud POST
            $response = $cliente->post("$url/api/auditoria", [
                'headers' => $headers,
                'json' => $data,
            ]);
            $respuesta = $response->getBody();
            Log::info('respuesta api auditoria'. json_encode($respuesta));
            return $respuesta;
        } catch (\Throwable $th) {
            Log::error('api error : ' . $th->getMessage());
            return $th->getMessage();
        }

    }
    public function getAudiData($fecha_inicio,$fecha_fin,$company_id){

        $url          = env('API_AUDITORIA','');
        try {
            $token = $this->getToken();
            $cliente = new Client();
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            // Realizar la solicitud POST
            $response = $cliente->get("$url/api/auditoria", [
                'headers' => $headers,
                'json' => [
                    'company_id' => $company_id,
                    'date_from' => $fecha_inicio,
                    'date_to' => $fecha_fin
                ],
            ]);
            $respuesta = $response->getBody();
            Log::info('respuesta api auditoria'. json_encode($respuesta));
            return $respuesta;
        } catch (\Throwable $th) {
            Log::error('api error : ' . $th->getMessage());
            return $th->getMessage();
        }
    }
}
