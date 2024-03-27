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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('organizer_id')->constrained('organizers');
            $table->string('title');
            $table->longText('description');
            $table->string('type');
            $table->date('date');
            $table->string('localisation');
            $table->json('required_skills');
            $table->string('status')->default('Pending');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
