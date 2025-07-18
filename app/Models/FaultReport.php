<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaultReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'user_id',
        'description',
        'image_path',
        'status',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->hasMany(FaultReportMedia::class);
    }
} 