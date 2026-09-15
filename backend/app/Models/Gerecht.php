<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gerecht extends Model
{
    protected $table = 'menu';

    public $timestamps = false;

    protected $fillable = [
        'menunummer',
        'menu_toevoeging',
        'naam',
        'beschrijving',
        'soortgerecht',
        'price',
        'actief',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'menunummer' => 'integer',
            'price' => 'decimal:2',
            'actief' => 'boolean',
        ];
    }
}