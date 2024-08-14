<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'species_id',
        'conversion_factor',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }
}
