<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    use HasFactory, HasUuids;

    protected $table = "category";
    protected $primaryKey = "id";
    public $incrementing =  false;
    public $keyType = "string";


    protected $fillable = [
        'nm_category'
    ];

    function Product(): HasMany
    {
        return $this->hasMany(product::class);
    }
}
