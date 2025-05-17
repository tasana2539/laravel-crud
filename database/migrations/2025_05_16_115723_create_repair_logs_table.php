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
        Schema::create('repair_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->string('updated_by_name')->nullable();
            $table->enum('status_before', ['pending', 'assigned', 'in_progress', 'completed', 'rejected','cancel']);
            $table->enum('status_after', ['pending', 'assigned', 'in_progress', 'completed', 'rejected','cancel']);
            $table->text('note')->nullable();
            $table->timestamp('previous_updated_at')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_logs');
    }
};
