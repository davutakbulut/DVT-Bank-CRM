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
    public ?int $selectedAdviceId = null;
    public bool $showAdviceModal = false;

    public function sendMessage(): void
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $userText = $this->message;
        $this->reset('message');

        // Önceki sohbet akışı geçmişi (AI bağlam koruması için)
        $recentHistory = AiChatMessage::where('user_id', $user->id)
            ->latest()
            ->take(8)
            ->get()
            ->reverse()
            ->toArray();

        // Kullanıcı mesajını kaydet
        AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'user',
            'content' => $userText,
        ]);

        $aiManager = new AiManager();
        $reply = $aiManager->chat($user, $userText, $recentHistory);

        // Asistan yanıtını kaydet
        AiChatMessage::create([
            'user_id' => $user->id,
            'role' => 'assistant',
            'content' => $reply,
        ]);
    }

    public function clearChat(): void
    {
        $user = Auth::user();
        if ($user) {
            AiChatMessage::where('user_id', $user->id)->delete();
            session()->flash('message', 'Sohbet geçmişiniz temizlendi.');
        }
    }

    public function generateFullAnalysis(): void
    {
        $this->isGeneratingAnalysis = true;
        $aiManager = new AiManager();
        $aiManager->generateAdviceForUser(Auth::user(), 'analysis');
        $this->isGeneratingAnalysis = false;
        session()->flash('message', 'Detaylı finansal kriz durum analiziniz hazırlandı.');
    }

    public function viewAdvice(int $id): void
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $advice = AiAdvice::where('user_id', $user->id)->find($id);
        if ($advice) {
            $this->selectedAdviceId = $advice->id;
            $this->showAdviceModal = true;
        }
    }

    public function closeAdviceModal(): void
    {
        $this->showAdviceModal = false;
        $this->selectedAdviceId = null;
    }

    public function render()
    {
        $user = Auth::user();
        $advices = AiAdvice::where('user_id', $user->id)->latest()->take(10)->get();
        $chatMessages = AiChatMessage::where('user_id', $user->id)->latest()->take(50)->get()->reverse();

        $selectedAdvice = $this->selectedAdviceId 
            ? AiAdvice::where('user_id', $user->id)->find($this->selectedAdviceId)
            : null;

        return view('livewire.ai.coach', [
            'advices' => $advices,
            'chatMessages' => $chatMessages,
            'selectedAdvice' => $selectedAdvice,
        ])->layout('layouts.app');
    }
}
