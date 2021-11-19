<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasinoListing extends Model
{
    use HasFactory;

    protected $with = ['country', 'casino:id,name'];

    protected $table = "casino_listings";

    protected $hidden = ["created_at", "updated_at"];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function casino()
    {
        return $this->belongsTo(Casino::class);
    }
}
