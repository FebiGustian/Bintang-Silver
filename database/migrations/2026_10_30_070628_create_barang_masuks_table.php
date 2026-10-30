
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->restrictOnDelete();

            $table->string('nomor_transaksi', 50)->unique();
            $table->date('tanggal_masuk');
            $table->string('nomor_referensi')->nullable();

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('diskon', 15, 2)->default(0);
            $table->decimal('pajak', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);

            $table->enum('status', [
                'draft',
                'completed',
                'cancelled'
            ])->default('draft');

            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('tanggal_masuk');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
