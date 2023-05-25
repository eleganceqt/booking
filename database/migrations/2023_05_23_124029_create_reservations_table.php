<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id');
            $table->bigInteger('guest_id');
            $table->timestamp('reserved_at');
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->tinyInteger('status');
            $table->timestamps();

            $table
                ->foreign('room_id')
                ->references('id')
                ->on('rooms')
                ->cascadeOnDelete();

            $table
                ->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->cascadeOnDelete();


        });

        // checkin_date < checkout_date constraint
        DB::statement("
            alter table reservations
            add constraint reservation_interval check (
                checkin_date < checkout_date
            )
        ");

        // reservation overlap constraint
        DB::statement("
            alter table reservations
            add constraint overlapping_reservation exclude using gist (
                room_id WITH =,
                daterange(checkin_date, checkout_date, '[)') with &&
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
