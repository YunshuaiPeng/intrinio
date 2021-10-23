<?php

namespace Database\Seeders;

use App\Models\Security;
use Illuminate\Database\Seeder;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        $security = new Security;
        $security->reference_id = 'sec_agjrgj';
        $security->company_id = 'com_NX6GzO';
        $security->stock_exchange_id = 'sxg_ozMr9y';
        $security->name = 'Apple Inc';
        $security->ticker = 'AAPL';
        $security->code = 'EQS';
        $security->currency = 'USD';
        $security->save();
    }
}
