<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $table = 'school_profile';

    protected $fillable = [
        'name',
        'npsn',
        'address',
        'phone',
        'fax',
        'email',
        'website',
        'principal_name',
        'principal_nip',
        'established_year',
        'vision',
        'mission',
        'missions',
        'values',
        'organization_structure',
        'motto',
        'logo',
        'favicon',
        'social_media',
        'accreditation',
        'history',
        'facilities',
        'school_photo',
    ];

    protected function casts(): array
    {
        return [
            'social_media' => 'array',
            'facilities' => 'array',
            'missions' => 'array',
            'values' => 'array',
            'organization_structure' => 'array',
            'established_year' => 'integer',
        ];
    }

    /**
     * Get school profile (singleton pattern)
     */
    public static function getProfile(): ?self
    {
        return static::first();
    }
}
