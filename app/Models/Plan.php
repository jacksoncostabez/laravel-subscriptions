<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function getPriceBrAttibute()
    {
        return number_format($this->price, 2, ',', '.');
    }
}
