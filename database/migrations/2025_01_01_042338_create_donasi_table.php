<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->string('order_id')->unique();
            $table->foreignId('donasi_id')->constrained('donasi')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_donatur');
            $table->decimal('jumlah_donasi', 10, 2);
            $table->text('keterangan')->nullable();
            $table->enum('status_pembayaran', ['pending', 'settlement', 'cancel', 'expire', 'failure']);
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_detail');
        Schema::dropIfExists('donasi');
    }
};
