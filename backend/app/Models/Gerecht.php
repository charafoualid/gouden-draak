<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    protected $table = 'menu';

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'menunummer' => 'integer',
            'price' => 'decimal:2',
        ];
    }
}