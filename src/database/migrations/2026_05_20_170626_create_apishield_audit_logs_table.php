<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apishield_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('application_id')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('http_method')->nullable();
            $table->integer('status_code')->nullable();
            $table->string('action')->nullable();
            $table->string('result')->nullable();
            $table->string('failure_reason')->nullable();
            $table->integer('attempts')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apishield_audit_logs');
    }
};