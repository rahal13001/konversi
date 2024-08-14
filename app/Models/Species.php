<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    protected $fillable = [
        'species',
        'local_name',
        'weight',
    ];

    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }

}
