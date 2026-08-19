<?php

namespace App\Livewire\Ai;

use App\Livewire\Concerns\HandlesNotifications;
use App\Models\AiAdvice;
use App\Models\AiChatMessage;
use App\Services\AI\AiManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Coach extends Component
{
    use HandlesNotifications;

    public string $message = '';
    public bool $isGeneratingAnalysis = false;

    public function sendMessage(): void
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $userText = $this->message;
        $this->reset('message');

        // Kullanıcı mesajını kaydet
        AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $userText,
        ]);

        $aiManager = new AiManager();
        $reply = $aiManager->chat($user, $userText);

        // Asistan yanıtını kaydet
        AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => $reply,
        ]);
    }

    public function generateFullAnalysis(): void
    {
        $this->isGeneratingAnalysis = true;
        $aiManager = new AiManager();
        $aiManager->generateAdviceForUser(Auth::user(), 'analysis');
        $this->isGeneratingAnalysis = false;
        session()->flash('message', 'Detaylı finansal kriz durum analiziniz hazırlandı.');
    }

    public function render()
    {
        $user = Auth::user();
        $advices = AiAdvice::where('user_id', $user->id)->latest()->take(5)->get();
        $chatMessages = AiChatMessage::where('user_id', $user->id)->latest()->take(20)->get()->reverse();

        return view('livewire.ai.coach', [
            'advices' => $advices,
            'chatMessages' => $chatMessages,
        ])->layout('layouts.app');
    }
}
