<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_loket');
            $table->string('deskripsi')->nullable();
            $table->string('kode_prefix', 5)->nullable();
            $table->timestamps();

            $table->unique('nama_loket');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokets');
    }
};