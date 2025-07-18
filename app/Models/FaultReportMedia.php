<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaultReportMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'fault_report_id',
        'media_type',
        'file_path',
    ];

    public function faultReport(): BelongsTo
    {
        return $this->belongsTo(FaultReport::class);
    }
} 