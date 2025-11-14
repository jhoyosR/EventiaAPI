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
        Schema::create('participants', function (Blueprint $table) {
            $table->charset     = 'utf8mb4';
            $table->collation   = 'utf8mb4_general_ci';

            $table->comment('TABLA DE PARTICIPANTES');
            $table->id()->unique('id_unique');
            $table->string('name')->comment('NOMBRE')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('email')->unique('participants_email_unique')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('phone_number')->comment('TELÉFONO')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('identification')->comment('IDENTIFICACIÓN')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->date('birth_date')->comment('FECHA DE NACIMIENTO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
