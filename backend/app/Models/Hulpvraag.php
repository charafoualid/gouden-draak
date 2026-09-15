<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hulpvraag extends Model
{
    protected $table = 'hulpvragen';

    public $timestamps = false;

    protected $fillable = [
        'tafelnummer',
        'aangemaakt_op',
        'afgehandeld',
    ];

    protected function casts(): array
    {
        return [
            'tafelnummer' => 'integer',
            'aangemaakt_op' => 'datetime',
            'afgehandeld' => 'boolean',
        ];
    }
}