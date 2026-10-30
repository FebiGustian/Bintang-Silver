
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();

            // Relasi kategori
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->restrictOnDelete();

            // Identitas produk
            $table->string('sku', 50)->unique();
            $table->string('barcode', 100)->nullable()->unique();
            $table->string('qr_code', 100)->nullable()->unique();
            $table->string('nama_barang', 150);
            $table->string('slug')->unique();

            // Detail produk
            $table->text('deskripsi')->nullable();
            $table->string('merek', 100)->nullable();
            $table->string('satuan', 30)->default('pcs');

            // Informasi harga
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);

            // Informasi persediaan
            $table->unsignedInteger('stok')->default(0);
            $table->unsignedInteger('stok_minimum')->default(5);
            $table->string('lokasi_penyimpanan', 100)->nullable();

            // Status produk
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index('nama_barang');
            $table->index('kategori_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
