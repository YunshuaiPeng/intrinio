<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SecurityHistoricalDatumResource;
use App\Models\Security;
use App\Models\SecurityHistoricalDatum;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SecurityHistoricalDatumController extends Controller
{
    public function index(Request $request, Security $security, string $tag)
    {
        $request->validate([
            'frequency' => [
                'required',
                'string',
                Rule::in(SecurityHistoricalDatum::frequencies()),
            ],
            'tag' => [
                'required',
                'string',
                Rule::in(SecurityHistoricalDatum::tags()),
            ],
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        $frequency = $request->input('frequency');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $data = $security
            ->historicalData()
            ->ofFrequency($frequency)
            ->ofTag($tag)
            ->betweenDate($startDate, $endDate)
            ->orderBy('date', 'asc')
            ->get();

        return SecurityHistoricalDatumResource::collection($data);
    }
}
