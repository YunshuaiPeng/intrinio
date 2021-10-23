<?php

namespace Database\Seeders;

use App\Models\Security;
use Illuminate\Database\Seeder;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        $this->apple();
        $this->intel();
        $this->microsoft();
    }

    protected function apple()
    {
        $security = new Security;
        $security->reference_id = 'sec_agjrgj';
        $security->company_id = 'com_NX6GzO';
        $security->stock_exchange_id = 'sxg_ozMr9y';
        $security->name = 'Apple Inc';
        $security->ticker = 'AAPL';
        $security->code = 'EQS';
        $security->currency = 'USD';
        $security->logo = '/storage/security_logo/apple.png';
        $security->save();
    }

    protected function intel()
    {
        $security = new Security;
        $security->reference_id = 'sec_zvNxEz';
        $security->company_id = 'com_NgYGzd';
        $security->stock_exchange_id = 'sxg_ozMr9y';
        $security->name = 'Intel Corp.';
        $security->ticker = 'INTC';
        $security->code = 'EQS';
        $security->currency = 'USD';
        $security->logo = '/storage/security_logo/intel.png';
        $security->save();
    }

    protected function microsoft()
    {
        $security = new Security;
        $security->reference_id = 'sec_XaL6mg';
        $security->company_id = 'com_qzEByJ';
        $security->stock_exchange_id = 'sxg_ozMr9y';
        $security->name = 'Microsoft Corporation';
        $security->ticker = 'MSFT';
        $security->code = 'EQS';
        $security->currency = 'USD';
        $security->logo = '/storage/security_logo/microsoft.png';
        $security->save();
    }
}
