<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('template_purchases')) {
            Schema::create('template_purchases', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('template_slug');
                $table->decimal('amount_usd', 8, 2)->default(5.00);
                $table->string('status')->default('completed'); // completed, pending, failed
                $table->string('source')->default('stripe'); // stripe, courtesy, test
                $table->string('stripe_session_id')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['user_id', 'template_slug']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('template_purchases');
    }
};
