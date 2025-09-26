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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained(
                table: 'pegawai',
                indexName: 'attendances_pegawai_id'
            );
            $table->date('date')->nullable();
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
            // $table->foreignId('shift_id')->nullable()->constrained(
            //     table: 'shift',
            //     indexName: 'attendances_shift_id'
            // );
            $table->enum('status', [
                'present', // hadir
                'late', // terlambat
                'excused', // izin
                'sick', // sakit
                'absent' // tidak hadir
            ])->default('absent');
            $table->string('note')->nullable(); // keterangan
            $table->string('attachment')->nullable(); // lampiran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
