<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Faq;
use App\Services\DeepSeekService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    protected DeepSeekService $deepSeek;

    public function __construct(DeepSeekService $deepSeek)
    {
        $this->deepSeek = $deepSeek;
    }

    /**
     * Display the chatbot interface.
     */
    public function index()
    {
        return view('chatbot.index');
    }

    /**
     * Start a new chat session or get existing one.
     */
    public function session(Request $request)
    {
        $sessionId = $request->input('session_id') ?? Str::uuid()->toString();

        $session = ChatSession::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'user_id' => auth()->id(),
                'title' => 'Chat ' . now()->format('d M Y H:i'),
            ]
        );

        return response()->json([
            'session_id' => $session->session_id,
            'messages' => $session->messages->map(fn($m) => [
                'role' => $m->role,
                'content' => $m->content,
                'created_at' => $m->created_at->format('H:i'),
            ]),
        ]);
    }

    /**
     * Send a message to the chatbot.
     */
    public function send(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        // Get or create session
        $session = ChatSession::firstOrCreate(
            ['session_id' => $validated['session_id']],
            [
                'user_id' => auth()->id(),
                'title' => Str::limit($validated['message'], 50),
            ]
        );

        // Save user message FIRST
        $userMsg = ChatMessage::create([
            'chat_session_id' => $session->id,
            'role' => 'user',
            'content' => $validated['message'],
        ]);

        // Refresh the session to get updated messages
        $session->refresh();

        // Get conversation history (now includes the just-saved user message)
        $messages = $session->getRecentMessages(8);

        // Log for debugging
        Log::info('Chatbot Send', [
            'session_id' => $session->id,
            'user_message' => $validated['message'],
            'history_count' => count($messages),
            'history' => $messages,
        ]);


        // Get AI response (system prompt is now handled internally by DeepSeekService)
        $result = $this->deepSeek->chat($messages);

        // Save assistant response
        $assistantMessage = ChatMessage::create([
            'chat_session_id' => $session->id,
            'role' => 'assistant',
            'content' => $result['message'],
            'metadata' => $result['usage'] ?? null,
        ]);

        return response()->json([
            'success' => $result['success'] ?? true,
            'message' => [
                'role' => 'assistant',
                'content' => $result['message'],
                'created_at' => $assistantMessage->created_at->format('H:i'),
            ],
        ]);
    }

    /**
     * Clear chat history.
     */
    public function clear(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|string',
        ]);

        $session = ChatSession::where('session_id', $validated['session_id'])->first();

        if ($session) {
            $session->messages()->delete();
        }

        return response()->json(['success' => true]);
    }
}
