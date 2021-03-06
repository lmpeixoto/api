<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('occurrences', static function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedTinyInteger('type_id');
            $table->unsignedTinyInteger('status_id');
            $table->unsignedSmallInteger('parish_id');
            $table->string('locality');

            $table->morphs('source');

            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();

            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onUpdate('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('occurrence_types')
                ->onUpdate('cascade');

            $table->foreign('status_id')
                ->references('id')
                ->on('occurrence_statuses')
                ->onUpdate('cascade');

            $table->foreign('parish_id')
                ->references('id')
                ->on('parishes')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('occurrences');
    }
}
