<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'location',
        'modality',
        'salary_min',
        'salary_max',
        'currency',
        'is_active',
        'risk_score',
        'risk_flags',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'risk_flags' => 'array',
        'salary_min' => 'integer',
        'salary_max' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
