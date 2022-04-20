<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->decimal('sem_1', 3, 2)->nullable();
            $table->decimal('sem_2', 3, 2)->nullable();
            $table->decimal('sem_3', 3, 2)->nullable();
            $table->unsignedBigInteger('mahasiswa_id')->unique();
            $table->timestamps();
            // $table->foreignId('mahasiswa_id')->unique()->constrained();
            // $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas');
            $table->foreignId('mahasiswa_id')->unique()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilais');
    }
};
