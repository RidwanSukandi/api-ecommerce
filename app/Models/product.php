<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class product extends Model
{
    use HasFactory, HasUuids;

    protected $table = "products";
    protected $primaryKey = "id_product";
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'title',
        'price',
        'description',
        'category',
        'image',
        'rate',
        'count'
    ];

    public function category(): BelongsTo
    {

        return $this->belongsTo(category::class);
    }

    function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
