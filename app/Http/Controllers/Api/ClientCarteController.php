<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\clientCarte;
use Illuminate\Http\Request;

class ClientCarteController extends Controller
{
    public function getClientByMatrAndMobile($matr, $mobile)
    {
        $client = clientCarte::where('matr', $matr)
                             ->where('mobile', $mobile)
                             ->first();
    
        if ($client) {
            return response()->json($client);
        } else {
            return response()->json(['message' => 'Client not found'], 404);
        }
    }
}
