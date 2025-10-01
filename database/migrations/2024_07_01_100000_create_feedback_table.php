<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // <-- Tambah kolom type
            $table->unsignedBigInteger('buku_id')->nullable(); // <-- Tambah kolom buku_id
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nama');
            $table->string('email');
            $table->tinyInteger('rating')->nullable();
            $table->text('pesan');
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('bukus')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
