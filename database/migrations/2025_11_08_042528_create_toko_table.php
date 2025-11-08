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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id('id_toko');
            $table->string('nama_toko', 100);
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 100)->nullable();
            $table->string('kontak_toko', 13)->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('id_user')
                    ->constrained('users', 'id_user')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};
