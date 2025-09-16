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
        Schema::table('amazon_settings', function (Blueprint $table) {
            $table->text('amazon_email')->nullable()->after('user_id');
            $table->text('amazon_password')->nullable()->after('amazon_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amazon_settings', function (Blueprint $table) {
            $table->dropColumn(['amazon_email', 'amazon_password']);
        });
    }
};
