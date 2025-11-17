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
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'Low', 'Medium', 'High', 'Urgent'
            $table->string('slug');
            $table->string('color')->default('#6B7280');
            $table->integer('level')->default(0); // For ordering
            $table->timestamps();

            $table->unique(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
