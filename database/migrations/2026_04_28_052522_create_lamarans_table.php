<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');               // ID pelamar
            $table->unsignedBigInteger('lowongan_id');            // ID lowongan (hardcode key)
            $table->string('nama_lowongan')->nullable();           // Nama lowongan (simpan teks)
            $table->string('nama_perusahaan')->nullable();          // Nama perusahaan
            $table->text('pesan')->nullable();                       // Pesan/cover letter
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->timestamps();

            // Foreign key ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

            // Satu user tidak boleh melamar lowongan yang sama 2x
            $table->unique(['user_id', 'lowongan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};