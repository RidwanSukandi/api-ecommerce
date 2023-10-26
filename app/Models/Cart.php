<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cart';
    protected $primaryKey = 'id';
    public $incremwnting = false;
    public $keyType = 'string';

    protected $fillable = [
        'productId',
        'quantity'
    ];


    public function product(): BelongsTo
    {
        return  $this->belongsTo(product::class);
    }
}
