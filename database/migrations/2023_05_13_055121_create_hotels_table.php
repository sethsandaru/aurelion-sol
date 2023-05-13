<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('external_id')->index();
            $table->string('external_destination_id')->index();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state_code')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country_code')->nullable();
            $table->jsonb('images')->nullable();
            $table->jsonb('amenities')->nullable();
            $table->jsonb('booking_conditions')->nullable();
            $table->jsonb('additional_details')->nullable();

            $table->unique('external_id', 'destination_id');
            $table->timestamps();
        });
    }
};
