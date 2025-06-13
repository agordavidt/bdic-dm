<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuyerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'id_type',
        'id_number',
        'buyer_type',
        'institution_name',
        'tax_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class, 'buyer_id', 'user_id');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('buyer_type', $type);
    }

    public function scopeByLocation($query, $city = null, $state = null)
    {
        $query = $query->when($city, fn($q) => $q->where('city', $city));
        return $query->when($state, fn($q) => $q->where('state', $state));
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}";
    }
}