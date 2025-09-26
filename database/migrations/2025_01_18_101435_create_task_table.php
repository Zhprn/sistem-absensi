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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('tugas');
            $table->string('desc');
            $table->foreignId('sop_id')->nullable()->constrained(
                table: 'sop',
                indexName: 'task_sop_id'
            )->onDelete('cascade');
            $table->foreignId('bagian_id')->nullable()->constrained(
                table: 'bagian',
                indexName: 'task_bagian_id'
            )->onDelete('cascade');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
