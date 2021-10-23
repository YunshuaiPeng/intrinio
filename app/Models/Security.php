<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Security extends Model
{
    public function historicalData(): Relation
    {
        return $this->hasMany(SecurityHistoricalDatum::class);
    }

    public function scopeOfTicker($query, string $ticker): Builder
    {
        return $query->where('ticker', $ticker);
    }
}
