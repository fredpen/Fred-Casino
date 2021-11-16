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

    public function __construct()
    {
        $this->baseUrl = Config::get('app.url');
    }

    public function removeExistingLogo(): bool
    {
        $baseUrl = $this->baseUrl . "/storage/";
        $logoUrl = str_replace($baseUrl, '', $this->logo_url);

        return Storage::delete("public/{$logoUrl}");
    }

    public function storeNewLogo($logoFile): String
    {
        $path =  $logoFile->storePublicly('public/casino/logos');

        return $this->baseUrl . Storage::url($path);
    }
}
