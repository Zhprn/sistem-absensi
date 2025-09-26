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
        Schema::create('potongan', function (Blueprint $table) {
            $table->id();
            $table->decimal('asuransi', 15, 2)->nullable();;
            $table->decimal('bpjs', 15, 2)->nullable();
            $table->decimal('absen', 15, 2)->nullable();
            $table->decimal('lainnya', 15, 2)->nullable();
            $table->decimal('total_potongan', 15, 2)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongan');
    }
};
