<?php

namespace Database\Seeders;

use App\Models\Banom;
use App\Models\Member;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin (GANTI sandinya setelah login pertama)
        User::firstOrCreate(
            ['email' => 'admin@banom.test'],
            ['name' => 'Admin', 'password' => Hash::make('admin123')]
        );

        $daftar = [
            'IPNU'     => 'Ikatan Pelajar Nahdlatul Ulama',
            'IPPNU'    => 'Ikatan Pelajar Putri Nahdlatul Ulama',
            'Fatayat'  => 'Fatayat Nahdlatul Ulama',
            'Muslimat' => 'Muslimat Nahdlatul Ulama',
            'GP Ansor' => 'Gerakan Pemuda Ansor',
            'Banser'   => 'Barisan Ansor Serbaguna',
        ];

        $urut = 1;
        foreach ($daftar as $nama => $lengkap) {
            Banom::firstOrCreate(['nama' => $nama], ['tingkat' => $lengkap, 'urutan' => $urut++]);
        }

        if (Member::count() === 0) {
            $contoh = [
                ['IPNU', 'Ilham Maulana', 'Ketua'],
                ['IPPNU', 'Zahra Salsabila', 'Ketua'],
                ['Fatayat', 'Nur Fadilah', 'Ketua'],
                ['Muslimat', 'Siti Aminah', 'Ketua'],
                ['GP Ansor', 'Ahmad Fauzi', 'Ketua'],
                ['GP Ansor', 'Muhammad Rizky', 'Sekretaris'],
                ['Banser', 'Hasan Basri', 'Komandan'],
            ];
            foreach ($contoh as [$banom, $nama, $jabatan]) {
                Member::create([
                    'banom_id' => Banom::where('nama', $banom)->value('id'),
                    'nama' => $nama, 'jabatan' => $jabatan,
                    'alamat' => 'Contoh Alamat', 'tahun' => date('Y'), 'status' => 'aktif',
                ]);
            }
        }

        if (News::count() === 0) {
            News::create([
                'judul' => 'Pengajian Akbar Memperingati Harlah NU',
                'ringkasan' => 'Keluarga besar NU menggelar pengajian akbar dalam rangka harlah.',
                'isi' => "Keluarga besar NU menggelar pengajian akbar dalam rangka harlah. Acara dihadiri pengurus IPNU, IPPNU, Fatayat, Muslimat, GP Ansor, dan Banser.\n\nKegiatan berlangsung khidmat dan diikuti ratusan jamaah.",
                'kategori' => 'Kegiatan', 'published_at' => now()->subDays(20),
            ]);
            News::create([
                'judul' => 'Latihan Dasar Banser Angkatan Baru',
                'ringkasan' => 'Satkorcab Banser membuka latihan dasar bagi kader baru.',
                'isi' => 'Satkorcab Banser membuka latihan dasar bagi kader baru untuk memperkuat kedisiplinan dan pengabdian kepada masyarakat.',
                'kategori' => 'Kaderisasi', 'published_at' => now()->subDays(28),
            ]);
            News::create([
                'judul' => 'Rapat Koordinasi Seluruh Banom',
                'ringkasan' => 'Seluruh pengurus banom menyusun agenda kegiatan semester ini.',
                'isi' => 'Seluruh pengurus banom berkumpul untuk menyusun agenda kegiatan semester ini dan memperkuat kerja sama antarlembaga.',
                'kategori' => 'Organisasi', 'published_at' => now()->subDays(35),
            ]);
        }
    }
}
