<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table): void {
            $table->id();
            $table->date('feedback_date');
            $table->string('name', 80);
            $table->string('email', 120);
            $table->string('phone', 15);
            $table->string('message', 1000);
            $table->char('promotion', 1)->default('N');
            $table->char('channel_sms', 1)->default('N');
            $table->char('channel_whatsapp', 1)->default('N');
            $table->char('channel_email', 1)->default('N');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};