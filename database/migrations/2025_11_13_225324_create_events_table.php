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
        Schema::create('events', function (Blueprint $table) {
            $table->charset     = 'utf8mb4';
            $table->collation   = 'utf8mb4_general_ci';

            $table->comment('TABLA DE EVENTOS');
            $table->id()->unique('id_unique');
            $table->string('name')->comment('NOMBRE')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->text('description')->comment('DESCRIPCIÓN')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->dateTime('datetime')->comment('FECHA Y HORA');
            $table->string('location')->comment('UBICACIÓN')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->unsignedMediumInteger('capacity')->comment('CAPACIDAD');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
