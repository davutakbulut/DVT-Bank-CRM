<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\AiAdvice;
use App\Models\AiChatMessage;
use App\Services\AI\AiManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AiCoachController extends Controller
{
    public function generateAdvice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'nullable|in:daily,analysis,custom',
        ]);

        $aiManager = new AiManager();
        $advice = $aiManager->generateAdviceForUser(Auth::user(), $validated['type'] ?? 'daily');

        return response()->json([
            'status' => 'success',
            'data' => $advice,
        ]);
    }

    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Kullanıcı mesajı kaydet
        AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        $aiManager = new AiManager();
        $reply = $aiManager->chat($user, $validated['message']);

        // Asistan yanıtı kaydet
        $assistantMsg = AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => $reply,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => [
                'reply' => $reply,
                'message_id' => $assistantMsg->id,
            ],
        ]);
    }

    public function history(): JsonResponse
    {
        $userId = Auth::id();
        $advices = AiAdvice::where('user_id', $userId)->latest()->take(10)->get();
        $messages = AiChatMessage::where('user_id', $userId)->latest()->take(30)->get()->reverse();

        return response()->json([
            'status' => 'success',
            'data' => [
                'advices' => $advices,
                'messages' => array_values($messages->toArray()),
            ],
        ]);
    }
}
