<?php

use Illuminate\Database\Seeder;
use CurrencyConverter\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            ["AUD", "Australian dollar", "\u0024"],
            ["BGN", "Bulgarian lev", "\u043b\u0432"],
            ["BRL", "Brazilian real", "\u0052\u0024"],
            ["CAD", "Canadian dollar", "\u0024"],
            ["CHF", "Swiss franc", "\u0043\u0048\u0046"],
            ["CNY", "Chinese yuan renminbi", "\u00a5"],
            ["CZK", "Czech koruna", "\u004b\u010d"],
            ["DKK", "Danish krone", "\u006b\u0072"],
            ["EUR", "Euro", "\u20ac"],
            ["GBP", "Pound sterling", "\u00a3"],
            ["HKD", "Hong Kong dollar", "\u0024"],
            ["HRK", "Croatian kuna", "\u006b\u006e"],
            ["HUF", "Hungarian forint", "\u0046\u0074"],
            ["IDR", "Indonesian rupiah", "\u0052\u0070"],
            ["ILS", "Israeli shekel", "\u20aa"],
            ["INR", "Indian rupee", "\u20B9"],
            ["JPY", "Japanese yen", "\u00a5"],
            ["KRW", "South Korean won", "\u20a9"],
            ["MXN", "Mexican peso", "\u0024"],
            ["MYR", "Malaysian ringgit", "\u0052\u004d"],
            ["NOK", "Norwegian krone", "\u006b\u0072"],
            ["NZD", "New Zealand dollar", "\u0024"],
            ["PHP", "Philippine peso", "\u20b1"],
            ["PLN", "Polish zloty", "\u007a\u0142"],
            ["RON", "Romanian leu", "\u006c\u0065\u0069"],
            ["RUB", "Russian rouble", "\u0440\u0443\u0431"],
            ["SEK", "Swedish krona", "\u006b\u0072"],
            ["SGD", "Singapore dollar", "\u0024"],
            ["THB", "Thai baht", "\u0e3f"],
            ["TRY", "Turkish lira", "\u20a4"],
            ["USD", "US dollar", "\u0024"],
            ["ZAR", "South African rand", "\u0052"],
        ];

        foreach ($currencies as $currency) {
            Currency::create([
                'currency' => $currency[0],
                'name' => $currency[1],
                'symbol' => $currency[2]
            ]);
        }
    }
}
