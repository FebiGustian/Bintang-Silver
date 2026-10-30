<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tabel = ['detail_barang_masuks', 'detail_barang_keluars', 'barang_masuks', 'barang_keluars'];

        foreach ($tabel as $t) {
            if (Schema::hasTable($t) && DB::table($t)->count() > 0) {
                throw new RuntimeException("Tabel {$t} sudah berisi data. Migration dihentikan supaya data tidak hilang.");
            }
        }

        foreach ($tabel as $t) {
            Schema::dropIfExists($t);
        }

        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nomor_transaksi')->unique();
            $table->date('tanggal');
            $table->string('pihak')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index(['cabang_id', 'tanggal']);
        });

        Schema::create('detail_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_masuk_id')->constrained('barang_masuks')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->unsignedInteger('jumlah');
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabangs');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nomor_transaksi')->unique();
            $table->date('tanggal');
            $table->string('pihak')->nullable();
            $table->string('nomor_referensi')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->index(['cabang_id', 'tanggal']);
        });

        Schema::create('detail_barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_keluar_id')->constrained('barang_keluars')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->unsignedInteger('jumlah');
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['detail_barang_masuks', 'detail_barang_keluars', 'barang_masuks', 'barang_keluars'] as $t) {
            Schema::dropIfExists($t);
        }
    }
};
