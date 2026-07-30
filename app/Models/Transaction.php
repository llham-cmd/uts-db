<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'event_id',
        'order_id',
        'ticket_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
        'snap_token',
        'is_checked_in',
        'checked_in_at',
        'checked_in_by',
    ];

    protected $casts = [
        'is_checked_in' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Setiap transaksi baru otomatis dapat kode tiket unik untuk QR check-in
        static::creating(function (Transaction $transaction) {
            if (empty($transaction->ticket_code)) {
                $transaction->ticket_code = (string) Str::uuid();
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function checkedInBy()
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    // Tiket dianggap sah untuk masuk hanya jika sudah lunas
    public function isPaid(): bool
    {
        return in_array($this->status, ['settlement', 'success', 'capture']);
    }
}