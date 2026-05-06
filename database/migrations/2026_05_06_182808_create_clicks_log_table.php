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
        Schema::create('clicks_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('links')->cascadeOnDelete();
            $table->string('domain_source')->index();
            $table->string('ip', 45);
            $table->text('user_agent');
            $table->string('country', 2)->nullable()->index();
            $table->text('referrer')->nullable();
            $table->timestamp('created_at')->useCurrent()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks_log');
    }
};
