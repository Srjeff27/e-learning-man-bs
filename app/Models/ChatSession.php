<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'title',
        'context',
    ];

    protected function casts(): array
    {
        return [
            'context' => 'array',
        ];
    }

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get chat messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    /**
     * Get recent messages for context.
     * Returns messages in chronological order (oldest first, newest last)
     * which is required by chat APIs like DeepSeek.
     */
    public function getRecentMessages(int $limit = 10): array
    {
        // Get the latest N messages, ordered by created_at ASC (oldest first)
        return $this->messages()
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->sortBy('created_at')  // Re-sort to chronological order
            ->values()
            ->map(fn($m) => [
                'role' => $m->role,
                'content' => $m->content,
            ])
            ->toArray();
    }
}
