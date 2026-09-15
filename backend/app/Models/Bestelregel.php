<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bestelregel extends Model
{
    protected $table = 'bestelregels';

    public $timestamps = false;

    protected $fillable = [
        'bestelling_id',
        'menu_id',
        'aantal',
        'opmerking',
    ];

    protected function casts(): array
    {
        return [
            'bestelling_id' => 'integer',
            'menu_id' => 'integer',
            'aantal' => 'integer',
        ];
    }

    public function bestelling(): BelongsTo
    {
        return $this->belongsTo(Bestelling::class, 'bestelling_id');
    }

    public function gerecht(): BelongsTo
    {
        return $this->belongsTo(Gerecht::class, 'menu_id');
    }
}