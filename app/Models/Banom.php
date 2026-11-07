<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banom extends Model
{
    protected $fillable = ['nama', 'tingkat', 'urutan'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    // Pengurus = anggota aktif dengan jabatan selain "Anggota", diurutkan menurut jabatan
    public function pengurus()
    {
        return $this->hasMany(Member::class)
            ->where('status', 'aktif')
            ->where('jabatan', '!=', 'Anggota')
            ->orderByRaw("CASE jabatan WHEN 'Ketua' THEN 1 WHEN 'Komandan' THEN 2 WHEN 'Wakil Ketua' THEN 3 WHEN 'Wakil Komandan' THEN 4 WHEN 'Sekretaris' THEN 5 WHEN 'Bendahara' THEN 6 ELSE 9 END")
            ->orderBy('nama');
    }
}
