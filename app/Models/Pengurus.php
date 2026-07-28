<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $fillable = [
        'jabatan_id', 'name', 'description', 'salary', 'created_by', 'updated_by',
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}