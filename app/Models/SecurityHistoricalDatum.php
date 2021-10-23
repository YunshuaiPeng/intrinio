<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class SecurityHistoricalDatum extends Model
{
    protected $fillable = [
        'tag',
        'frequency',
        'date',
        'value',
    ];

    public function security(): Relation
    {
        return $this->belongsTo(Security::class);
    }
}
