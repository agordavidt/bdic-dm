<?php




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_identifier',
        'device_type',
        'model',
        'brand',
        'specifications',
        'category_id',
        'vendor_id',
        'buyer_id',
        'buyer_category',
        'status',
        'price',
        'purchase_date',
        'warranty_expiry',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function buyerProfile(): BelongsTo
    {
        return $this->belongsTo(BuyerProfile::class, 'buyer_id', 'user_id');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(DeviceTransfer::class);
    }

    public function faultReports(): HasMany
    {
        return $this->hasMany(FaultReport::class);
    }

    // Scopes
    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeByBuyer($query, $buyerId)
    {
        return $query->where('buyer_id', $buyerId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByBuyerCategory($query, $category)
    {
        return $query->where('buyer_category', $category);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function needsAttention()
    {
        return $this->status === 'needs_attention';
    }

    public function isStolen()
    {
        return $this->status === 'stolen';
    }

    public function getDisplayNameAttribute()
    {
        return "{$this->brand} {$this->model} ({$this->unique_identifier})";
    }

    public function isWarrantyValid()
    {
        return $this->warranty_expiry && $this->warranty_expiry->isFuture();
    }
}
