<?php

use App\Models\Status;
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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // For idempotency
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //sender id
            $table->foreignId('parent_id')->nullable()->constrained('messages')->onDelete('cascade'); // For replies/threads
            $table->text('content')->nullable();
            $table->string('type')->default('text');
            $table->json('metadata')->nullable(); // For file size, duration, dimensions, etc.
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();

            $table->index(['conversation_id', 'created_at']);
            $table->index('user_id');
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
