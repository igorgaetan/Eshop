<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage()
    {
        $service = new WhatsAppApi();
        $response = $service->sendChatMessage('678734604', 'good');

        return response()->json($response);
    }
}
