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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama_pegawai');
            $table->string('alamat');
            $table->tinyInteger('gender')->default(0);
            $table->date('tgl_lahir')->nullable();
            $table->foreignId('jabatan_id')->constrained(
                table: 'jabatan',
                indexName: 'pegawai_jabatan_id'
            );
            $table->foreignId('bagian_id')->constrained(
                table: 'bagian',
                indexName: 'pegawai_bagian_id'
            );
            $table->foreignId('shift_id')->constrained(
                table: 'shift',
                indexName: 'pegawai_shift_id'
            );
            $table->string('foto')->nullable();
            $table->integer('telepon')->nullable();
            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Relasi ke tabel user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('pegawai');
    }
};
