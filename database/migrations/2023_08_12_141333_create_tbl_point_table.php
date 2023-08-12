<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_point', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('tbl_member');
            $table->foreignId('institution_id')->references('id')->on('tbl_institution');
            $table->integer('points_earned');
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_point');
    }
};
