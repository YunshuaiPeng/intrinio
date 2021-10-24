<?php

namespace App\Http\Controllers;

use App\Models\Security;
use App\Models\SecurityHistoricalDatum;
use Illuminate\Http\Request;

class SecurityHistoricalDatumController extends Controller
{
    public function historicalData(Request $request, Security $security)
    {
        return view('SecurityHistoricalDatum.historicalData', [
            'security' => $security,
            'frequencies' => SecurityHistoricalDatum::supportFrequencies(),
        ]);
    }
}
