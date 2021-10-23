<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Carbon;

class SecurityHistoricalDatum extends Model
{
    const FREQUENCY_DAILY = 'daily';
    const FREQUENCY_WEEKLY = 'weekly';
    const FREQUENCY_MONTHLY = 'monthly';
    const FREQUENCY_QUARTERLY = 'quarterly';
    const FREQUENCY_YEARLY = 'yearly';

    protected $fillable = [
        'tag',
        'frequency',
        'date',
        'value',
    ];

    public static function frequencies(): array
    {
        return [
            self::FREQUENCY_DAILY,
            self::FREQUENCY_WEEKLY,
            self::FREQUENCY_MONTHLY,
            self::FREQUENCY_QUARTERLY,
            self::FREQUENCY_YEARLY,
        ];
    }

    public function security(): Relation
    {
        return $this->belongsTo(Security::class);
    }

    public function scopeOfFrequency($query, string $frequency): Builder
    {
        return $query->where('frequency', $frequency);
    }

    public function scopeBetweenDate($query, string $start, string $end): Builder
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        return $query->whereBetween('date', [$start, $end]);
    }
}
