<?php

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk', 100);
            $table->integer('harga');
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_upload')->default(FacadesDB::raw('CURRENT_DATE'));
            $table->foreignId('id_toko')
                ->constrained('tokos', 'id_toko')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('id_kategori')
                ->constrained('kategoris', 'id_kategori')
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
        Schema::dropIfExists('produk');
    }
};
