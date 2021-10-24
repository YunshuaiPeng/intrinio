<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SecurityHistoricalDatumResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tag' => $this->tag,
            'frequency' => $this->frequency,
            'date' => $this->date,
            'value' => round($this->value, 2),
        ];
    }
}
