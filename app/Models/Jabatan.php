<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'name', 'created_by', 'updated_by',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }
}