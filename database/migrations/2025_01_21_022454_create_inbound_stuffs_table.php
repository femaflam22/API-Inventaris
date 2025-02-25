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
        Schema::create('inbound_stuffs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('stuff_id');
            $table->integer('total');
            $table->dateTime('date_time');
            $table->string('proof_file');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_stuffs');
    }
};
