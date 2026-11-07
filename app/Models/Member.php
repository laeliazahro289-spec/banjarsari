<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public const JABATAN = ['Anggota', 'Ketua', 'Komandan', 'Wakil Ketua', 'Wakil Komandan', 'Sekretaris', 'Bendahara'];

    protected $fillable = ['banom_id', 'nia', 'nama', 'jabatan', 'alamat', 'telepon', 'tahun', 'foto', 'status'];

    protected static function booted(): void
    {
        // Buat Nomor Induk Anggota otomatis setelah data tersimpan
        static::created(function (Member $m) {
            if (!$m->nia) {
                $kode = strtoupper(str_replace(' ', '', optional($m->banom)->nama ?? 'NU'));
                $m->nia = 'NU-' . $kode . '-' . ($m->tahun ?: date('Y')) . '-' . str_pad($m->id, 4, '0', STR_PAD_LEFT);
                $m->saveQuietly();
            }
        });
    }

    public function banom()
    {
        return $this->belongsTo(Banom::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function getFotoUrlAttribute()
    {
        if (!$this->foto) {
            return null;
        }

        // Foto baru ada di public/uploads/..., foto lama (versi awal) ada di storage
        return str_starts_with($this->foto, 'uploads/')
            ? asset($this->foto)
            : asset('storage/' . $this->foto);
    }
}
