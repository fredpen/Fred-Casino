<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Casino extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function country()
    {
        return $this->belongsToMany(Country::class, 'casino_listings');
    }

    public function removeExistingLogo(): bool
    {
        $baseUrl = Config::get('app.url');
        $baseUrl = $baseUrl . "/storage/";
        $logoUrl = str_replace($baseUrl, '', $this->logo_url);

        return Storage::delete("public/{$logoUrl}");
    }

    public function storeNewLogo($logoFile): String
    {
        $path =  $logoFile->storePublicly('public/casino/logos');
        $baseUrl = Config::get('app.url');

        return $baseUrl . Storage::url($path);
    }
}
