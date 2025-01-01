<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul_donasi');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->decimal('target_donasi', 10, 2);
            $table->decimal('donasi_terkumpul', 10, 2)->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['pending', 'active', 'completed', 'expired'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('donasi_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donasi_id')->constrained('donasi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_donatur');
            $table->decimal('jumlah_donasi', 10, 2);
            $table->text('keterangan')->nullable();
            $table->enum('status_pembayaran', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi_detail');
        Schema::dropIfExists('donasi');
    }
};
