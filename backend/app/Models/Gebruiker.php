<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Gebruiker extends Authenticatable
{
    protected $table = 'gebruiker';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $hidden = [
        'wachtwoord',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'isAdmin' => 'boolean',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'wachtwoord';
    }
}