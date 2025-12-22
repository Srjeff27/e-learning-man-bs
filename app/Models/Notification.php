<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'action_url',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Notification types.
     */
    public const TYPES = [
        'assignment' => ['icon' => '📝', 'color' => 'blue'],
        'grade' => ['icon' => '📊', 'color' => 'green'],
        'announcement' => ['icon' => '📢', 'color' => 'yellow'],
        'material' => ['icon' => '📚', 'color' => 'purple'],
        'attendance' => ['icon' => '✓', 'color' => 'teal'],
        'general' => ['icon' => '🔔', 'color' => 'gray'],
    ];

    /**
     * Get the user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read notifications.
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Check if notification is read.
     */
    public function getIsReadAttribute(): bool
    {
        return $this->read_at !== null;
    }

    /**
     * Get type icon.
     */
    public function getIconAttribute(): string
    {
        return self::TYPES[$this->type]['icon'] ?? '🔔';
    }

    /**
     * Create notification for a user.
     */
    public static function notify(
        int $userId,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null
    ): self {
        return static::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'data' => $data,
        ]);
    }

    /**
     * Notify multiple users.
     */
    public static function notifyMany(
        array $userIds,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null
    ): void {
        foreach ($userIds as $userId) {
            static::notify($userId, $type, $title, $message, $actionUrl, $data);
        }
    }
}
