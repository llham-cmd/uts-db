<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // nullable supaya event lama (sebelum multi-tenant) tidak error;
            // nullOnDelete supaya event tidak ikut terhapus kalau organizer dihapus
            $table->foreignId('organizer_id')->nullable()->after('category_id')
                ->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('organizer_id');
        });
    }
};