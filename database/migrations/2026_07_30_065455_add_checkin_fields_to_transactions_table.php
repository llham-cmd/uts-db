<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Kode unik khusus untuk QR check-in, terpisah dari order_id
            $table->string('ticket_code')->nullable()->unique()->after('order_id');

            // Status kehadiran peserta di hari-H
            $table->boolean('is_checked_in')->default(false)->after('status');
            $table->timestamp('checked_in_at')->nullable()->after('is_checked_in');

            // Admin/panitia mana yang melakukan scan (opsional, untuk audit trail)
            $table->foreignId('checked_in_by')->nullable()->after('checked_in_at')
                ->constrained('users')->nullOnDelete();
        });

        // Backfill ticket_code untuk transaksi lama yang sudah ada sebelum kolom ini dibuat
        Transaction::whereNull('ticket_code')->each(function (Transaction $trx) {
            $trx->update(['ticket_code' => (string) Str::uuid()]);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['checked_in_by']);
            $table->dropColumn(['ticket_code', 'is_checked_in', 'checked_in_at', 'checked_in_by']);
        });
    }
};