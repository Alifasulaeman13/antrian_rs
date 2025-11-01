<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loket_id')->constrained('lokets')->cascadeOnDelete();
            $table->string('nomor_antrian', 20);
            $table->string('status', 20)->default('menunggu');
            $table->timestamp('waktu_panggil')->nullable();
            $table->timestamps();

            $table->unique(['loket_id', 'nomor_antrian']);
            $table->index(['loket_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};