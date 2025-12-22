<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Scope for active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get FAQs formatted for chatbot context.
     */
    public static function getContextString(): string
    {
        $faqs = static::active()->orderBy('order')->get();

        if ($faqs->isEmpty()) {
            return '';
        }

        $context = "Berikut adalah FAQ sekolah:\n\n";
        foreach ($faqs as $faq) {
            $context .= "Q: {$faq->question}\n";
            $context .= "A: {$faq->answer}\n\n";
        }

        return $context;
    }
}
