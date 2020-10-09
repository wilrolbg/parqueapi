<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Mapa;
use Illuminate\Support\Facades\DB;

class mapaController extends Controller
{
    public function index(Request $request)
    {
        $Mapa = mapa::all();
            return [response()->json([
                'Success' => true,
                'Mapa' => $Mapa
            ])];
    }    
}
