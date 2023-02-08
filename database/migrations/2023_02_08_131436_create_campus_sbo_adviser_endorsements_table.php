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
        Schema::create('campus_sbo_adviser_endorsements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_sbo_adviser_id')->constrained()->onDelete('cascade');
            $table->foreignId('endorsement_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campus_sbo_adviser_endorsements');
    }
};
