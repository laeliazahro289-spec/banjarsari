<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banoms', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);              // IPNU, IPPNU, Fatayat, ...
            $table->string('tingkat')->nullable();   // nama lengkap / tingkat
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banoms');
    }
};
