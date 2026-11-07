<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banom_id')->constrained('banoms')->cascadeOnDelete();
            $table->string('nia')->nullable()->unique();           // nomor induk anggota (otomatis)
            $table->string('nama', 120);
            $table->string('jabatan', 60)->default('Anggota');     // "Anggota" = bukan pengurus
            $table->string('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('tahun', 4)->nullable();                // tahun bergabung
            $table->string('foto')->nullable();
            $table->string('status', 20)->default('aktif');        // pending | aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
