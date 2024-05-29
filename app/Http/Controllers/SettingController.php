<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;


class SettingController extends Controller
{
    public function getSetting(Request $request){
        
        $search = $request->input('search');
        $setting = new Setting();
        $setting->setConnection('mysql_2');
        $query = $setting->where('companyId','LIKE',"%$search%")
        ->orWhereRaw('LOWER(settingName) LIKE ?', ["%" . strtolower($search) . "%"])
        ->limit(5)->get();

        Log::info('valor search'. $search);
        return  response()->json($query,200);
    }
}
