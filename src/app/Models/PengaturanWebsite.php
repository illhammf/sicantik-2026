<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PengaturanWebsite extends Model
{
    protected $fillable = [
        'nama_website',

        'logo',
        'favicon',
        'gambar_hero',

        'badge_hero',
        'judul_hero',
        'deskripsi_hero',

        'judul_kontak',
        'deskripsi_kontak',

        'alamat',
        'no_hp',
        'email',

        'instagram',
        'facebook',
        'tiktok',
        'youtube',
        'whatsapp',

        'footer',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo
            ? Storage::url($this->logo)
            : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        return $this->favicon
            ? Storage::url($this->favicon)
            : null;
    }

    public function getGambarHeroUrlAttribute(): ?string
    {
        return $this->gambar_hero
            ? Storage::url($this->gambar_hero)
            : null;
    }
}