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
        Schema::table('products', function (Blueprint $table) {
            // 1. Identitas Kendaraan (Model, Brand, Type, CC already exist)
            $table->integer('year_manufacture')->nullable()->after('cc'); // Tahun Pembuatan
            $table->integer('year_assembly')->nullable()->after('year_manufacture'); // Tahun Perakitan
            $table->string('color')->nullable()->after('year_assembly'); // Warna

            // 2. Dokumen & Legalitas
            $table->string('stnk_status')->nullable(); // Ada/Tidak
            $table->string('bpkb_status')->nullable(); // Ada/Tidak/Sekolah
            $table->string('tax_status')->nullable(); // Hidup/Mati
            $table->date('tax_expiry')->nullable(); // Masa Berlaku Pajak/STNK
            $table->string('plate_number_status')->nullable(); // Asli/Mutasi

            // 3. Kondisi Fisik & Body
            $table->string('body_condition')->nullable(); // Mulus/Lecet
            $table->string('frame_condition')->nullable(); // Normal/Bengkok/Karat
            $table->string('legs_condition')->nullable(); // Stabil/Oblak
            $table->string('seat_condition')->nullable(); // Original/Modif
            $table->string('electrical_condition')->nullable(); // Lampu2

            // 4. Kondisi Mesin
            $table->string('engine_sound')->nullable(); // Normal/Kasar
            $table->string('oil_leak')->nullable(); // Kering/Bocor
            $table->string('exhaust_smoke')->nullable(); // Normal/Putih
            $table->string('engine_pull')->nullable(); // Responsif/Berat
            $table->string('fuel_consumption')->nullable(); // Irit/Boros
            $table->string('radiator_condition')->nullable(); 
            $table->string('battery_condition')->nullable();

            // 5. Odometer & Riwayat
            $table->integer('odometer')->nullable();
            $table->string('usage_type')->nullable(); // Harian/Touring/Kerja
            $table->string('usage_location')->nullable(); // Kota/Luar Kota

            // 6. Riwayat Servis
            $table->boolean('routine_service')->default(false);
            $table->boolean('service_book')->default(false);
            $table->text('service_notes')->nullable();
            $table->string('recent_part_replacement')->nullable();

            // 9. Bodi Tambahan & Modifikasi
            $table->string('exhaust_type')->nullable(); // Standar/Racing
            $table->text('modifications')->nullable(); // JSON or comma list for accessories
            $table->boolean('modifications_legal')->default(true);

            // 10. Inspeksi Kecelakaan
            $table->boolean('accident_history')->default(false);
            $table->boolean('flood_history')->default(false);
            $table->boolean('frame_damage')->default(false);
            $table->boolean('repainted')->default(false);
            $table->boolean('engine_overhaul')->default(false);

            // 12. Kelengkapan Unit
            $table->boolean('spare_key')->default(false);
            $table->boolean('toolkit')->default(false);
            $table->boolean('manual_book')->default(false);
            $table->boolean('bonus_helmet')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'year_manufacture', 'year_assembly', 'color',
                'stnk_status', 'bpkb_status', 'tax_status', 'tax_expiry', 'plate_number_status',
                'body_condition', 'frame_condition', 'legs_condition', 'seat_condition', 'electrical_condition',
                'engine_sound', 'oil_leak', 'exhaust_smoke', 'engine_pull', 'fuel_consumption', 'radiator_condition', 'battery_condition',
                'odometer', 'usage_type', 'usage_location',
                'routine_service', 'service_book', 'service_notes', 'recent_part_replacement',
                'exhaust_type', 'modifications', 'modifications_legal',
                'accident_history', 'flood_history', 'frame_damage', 'repainted', 'engine_overhaul',
                'spare_key', 'toolkit', 'manual_book', 'bonus_helmet'
            ]);
        });
    }
};
