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
        Schema::create('m_user_roles', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name', 50);
            $table->text('access');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->char('created_by', 36)->nullable()->default('0');
            $table->char('updated_by', 36)->nullable()->default('0');
            $table->char('deleted_by', 36)->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user_roles');
    }
};
