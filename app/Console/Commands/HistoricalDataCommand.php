<?php

namespace App\Console\Commands;

use App\Facades\Intrinio;
use App\Models\Security;
use Illuminate\Console\Command;

class HistoricalDataCommand extends Command
{
    protected $signature = 'intrinio:historical-data
                            {ticker : A Security ticker}
                            {tag=close_price : An Intrinio data tag ID or code (https://data.intrinio.com/data-tags)}
                            {--frequency=daily : Return historical data in the given frequency. Options: daily weekly monthly quarterly yearly}
                            {--start-date=2017-06-01 : Get historical data on or after this date}
                            {--end-date=2018-06-01 : Get historical date on or before this date}';

    protected $description = 'Returns historical values for the given `tag` and the Security with the given `ticker`';

    protected string $tag;
    protected string $frequency;
    protected ?string $nextPage = null;

    public function handle()
    {
        $ticker = $this->argument('ticker');
        $security = Security::query()->ofTicker($ticker)->firstOrFail();

        $this->tag = $this->argument('tag');
        $this->frequency = $this->option('frequency');

        start:
        $data = Intrinio::historicalDataForSecurity(
            $ticker,
            $this->tag,
            $this->frequency,
            $this->option('start-date'),
            $this->option('end-date'),
            '10',
            $this->nextPage
        );

        $this->storeData($security, $data);

        if ($data['next_page']) {
            sleep(1);
            $this->nextPage = $data['next_page'];
            goto start;
        }
    }

    protected function storeData(Security $security, array $data)
    {
        $records = collect($data['historical_data'])
            ->map(function ($datum) {
                return [
                    'tag' => $this->tag,
                    'frequency' => $this->frequency,
                    'date' => $datum['date'],
                    'value' => $datum['value'],
                ];
            });

        $security->historicalData()->createMany($records);
    }
}
