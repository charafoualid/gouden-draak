<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bestelling extends Model
{
    protected $table = 'bestellingen';

    public $timestamps = false;

    protected $fillable = [
        'besteldatum',
        'bron',
        'tafelnummer',
    ];

    protected function casts(): array
    {
        return [
            'besteldatum' => 'datetime',
            'tafelnummer' => 'integer',
        ];
    }

    public function bestelregels(): HasMany
    {
        return $this->hasMany(Bestelregel::class, 'bestelling_id');
    }
}