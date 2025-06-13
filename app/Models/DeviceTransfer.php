<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'from_user_id',
        'to_user_id',
        'transfer_type',
        'amount',
        'notes',
        'transfer_date',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function scopeByDevice($query, $deviceId)
    {
        return $query->where('device_id', $deviceId);
    }

    public function scopeByTransferType($query, $type)
    {
        return $query->where('transfer_type', $type);
    }
}