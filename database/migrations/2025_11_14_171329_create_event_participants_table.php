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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->charset     = 'utf8mb4';
            $table->collation   = 'utf8mb4_general_ci';

            $table->comment('INTERMEDIA DE EVENTOS CON PARTICIPANTES');
            $table->unsignedBigInteger('event_id')->index('fk_event_participants_events1_idx');
            $table->unsignedBigInteger('participant_id')->index('fk_event_participants_participants1_idx');

            $table->primary(['event_id', 'participant_id']);

            $table->foreign(['event_id'], 'fk_event_participants_events1')->references(['id'])->on('events')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['participant_id'], 'fk_event_participants_participants1')->references(['id'])->on('participants')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_participants', function (Blueprint $table) {
            $table->dropForeign('fk_event_participants_events1');
            $table->dropForeign('fk_event_participants_participants1');
        });
        Schema::dropIfExists('event_participants');
    }
};
