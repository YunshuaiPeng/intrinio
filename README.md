A repository for interview.

## 使用 artisan command 从 intrinio 获取数据
`php artisan intrinio:historical-data [options] [--] <ticker> [<tag>]`


```
Description:
  Returns historical values for the given `tag` and the Security with the given `ticker`

Usage:
  intrinio:historical-data [options] [--] <ticker> [<tag>]

Arguments:
  ticker                         A Security ticker
  tag                            An Intrinio data tag ID or code (https://data.intrinio.com/data-tags) [default: "close_price"]

Options:
      --frequency[=FREQUENCY]    Return historical data in the given frequency. Options: daily weekly monthly quarterly yearly [default: "daily"]
      --start-date[=START-DATE]  Get historical data on or after this date [default: "2017-06-01"]
      --end-date[=END-DATE]      Get historical date on or before this date [default: "2018-06-01"]
  -h, --help                     Display help for the given command. When no command is given display help for the list command
  -q, --quiet                    Do not output any message
  -V, --version                  Display this application version
      --ansi|--no-ansi           Force (or disable --no-ansi) ANSI output
  -n, --no-interaction           Do not ask any interactive question
      --env[=ENV]                The environment the command should run under
  -v|vv|vvv, --verbose           Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
