<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ChatController extends Controller
{
    public function index()
    {
        return response('Servidor activo correctamente');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'texto' => 'required|string'
        ]);
    
        try {
            // Crear una conversación con OpenAI
            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente útil. Responde siempre en español.'],
                    ['role' => 'user', 'content' => $request->texto],
                ],
            ]);
    
            // Obtener la respuesta del modelo de OpenAI
            $respuesta = $response->choices[0]->message->content;
    
            // Almacenar mensajes en la base de datos
            $chatMessage = new ChatMessage();
            $chatMessage->role = 'juan'; // Guarda el rol del usuario
            $chatMessage->content = $request->texto; // Guarda el mensaje del usuario
            $chatMessage->save();
    
            $chatMessage = new ChatMessage();
            $chatMessage->role = 'gpt'; // Guarda el rol del AI
            $chatMessage->content = $respuesta; // Guarda el mensaje del AI
            $chatMessage->save();
    
            // Devolver respuesta exitosa al frontend
            return response()->json(['respuesta' => $respuesta], 200);
        } catch (\Exception $e) {
            // Capturar y registrar el error
            Log::error('Error en ChatController: ' . $e->getMessage());
    
            // Devolver respuesta de error al frontend
            return response()->json(['error' => 'Error al obtener respuesta de OpenAI: ' . $e->getMessage()], 500);
        }
    }
}
