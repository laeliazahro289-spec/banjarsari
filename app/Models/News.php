<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['judul', 'ringkasan', 'isi', 'gambar', 'kategori', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            return null;
        }

        // Foto baru ada di public/uploads/..., foto lama (versi awal) ada di storage
        return str_starts_with($this->gambar, 'uploads/')
            ? asset($this->gambar)
            : asset('storage/' . $this->gambar);
    }
}
