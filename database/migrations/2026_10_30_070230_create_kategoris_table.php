
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();

            // Identitas kategori
            $table->string('kode_kategori', 20)->unique();
            $table->string('nama_kategori', 100);
            $table->string('slug')->unique();

            // Informasi kategori
            $table->text('deskripsi')->nullable();
            $table->string('warna', 7)->default('#2563EB');

            // Status kategori
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index('nama_kategori');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
