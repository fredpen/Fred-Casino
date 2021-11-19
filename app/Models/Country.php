<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ["created_at", "updated_at", "code"];

    public function casinos()
    {
        return $this->belongsToMany(Casino::class, 'casino_listings');
    }
}
