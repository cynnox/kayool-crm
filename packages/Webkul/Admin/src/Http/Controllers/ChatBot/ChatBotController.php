<?php

namespace Webkul\Admin\Http\Controllers\ChatBot;

use Webkul\Admin\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * ChatBot send message api endpoint
     * Read request body and send it into Rasa AI Chatbot message endpoint
     * Parse its response into json and return as response
     */
    public function sendMessage(Request $request){
        $data = $request->json()->all();
        $response = Http::post('https://chat.kayool.com/webhooks/rest/webhook',$data);
        return $response->json();
    }

}
