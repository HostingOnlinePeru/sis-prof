<?php

namespace App\Support;

use App\Models\CompanySetting;

class LatamCurrencies
{
    public static function all(): array
    {
        return [
            'PEN' => [
                'code' => 'PEN',
                'symbol' => 'S/.',
                'name' => 'Soles Peruanos',
                'country' => 'Perú',
            ],
            'USD' => [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'Dólares Americanos',
                'country' => 'EE.UU. / Ecuador / El Salvador / Panamá',
            ],
            'BOB' => [
                'code' => 'BOB',
                'symbol' => 'Bs.',
                'name' => 'Bolivianos',
                'country' => 'Bolivia',
            ],
            'COP' => [
                'code' => 'COP',
                'symbol' => 'COP $',
                'name' => 'Pesos Colombianos',
                'country' => 'Colombia',
            ],
            'MXN' => [
                'code' => 'MXN',
                'symbol' => 'MX$',
                'name' => 'Pesos Mexicanos',
                'country' => 'México',
            ],
            'CLP' => [
                'code' => 'CLP',
                'symbol' => 'CLP $',
                'name' => 'Pesos Chilenos',
                'country' => 'Chile',
            ],
            'ARS' => [
                'code' => 'ARS',
                'symbol' => 'ARS $',
                'name' => 'Pesos Argentinos',
                'country' => 'Argentina',
            ],
            'BRL' => [
                'code' => 'BRL',
                'symbol' => 'R$',
                'name' => 'Reales Brasileños',
                'country' => 'Brasil',
            ],
            'UYU' => [
                'code' => 'UYU',
                'symbol' => '$U',
                'name' => 'Pesos Uruguayos',
                'country' => 'Uruguay',
            ],
            'PYG' => [
                'code' => 'PYG',
                'symbol' => 'Gs.',
                'name' => 'Guaraníes',
                'country' => 'Paraguay',
            ],
            'VES' => [
                'code' => 'VES',
                'symbol' => 'Bs.D',
                'name' => 'Bolívares',
                'country' => 'Venezuela',
            ],
            'CRC' => [
                'code' => 'CRC',
                'symbol' => '₡',
                'name' => 'Colones Costarricenses',
                'country' => 'Costa Rica',
            ],
            'GTQ' => [
                'code' => 'GTQ',
                'symbol' => 'Q',
                'name' => 'Quetzales',
                'country' => 'Guatemala',
            ],
            'HNL' => [
                'code' => 'HNL',
                'symbol' => 'L',
                'name' => 'Lempiras',
                'country' => 'Honduras',
            ],
            'NIO' => [
                'code' => 'NIO',
                'symbol' => 'C$',
                'name' => 'Córdobas',
                'country' => 'Nicaragua',
            ],
            'PAB' => [
                'code' => 'PAB',
                'symbol' => 'B/.',
                'name' => 'Balboas',
                'country' => 'Panamá',
            ],
            'DOP' => [
                'code' => 'DOP',
                'symbol' => 'RD$',
                'name' => 'Pesos Dominicanos',
                'country' => 'República Dominicana',
            ],
            'CUP' => [
                'code' => 'CUP',
                'symbol' => 'CUP $',
                'name' => 'Pesos Cubanos',
                'country' => 'Cuba',
            ],
            'EUR' => [
                'code' => 'EUR',
                'symbol' => '€',
                'name' => 'Euros',
                'country' => 'Internacional',
            ],
        ];
    }

    public static function codes(): array
    {
        return array_keys(static::all());
    }

    public static function get(?string $code): array
    {
        $all = static::all();
        $upper = strtoupper(trim((string) $code));

        return $all[$upper] ?? $all['PEN'];
    }

    public static function symbol(?string $code): string
    {
        return static::get($code)['symbol'];
    }

    public static function name(?string $code): string
    {
        return static::get($code)['name'];
    }

    public static function optionLabel(string $code): string
    {
        $item = static::get($code);

        return "{$item['symbol']} — {$item['name']} ({$item['country']})";
    }

    public static function shortOptionLabel(string $code): string
    {
        $item = static::get($code);

        return "{$item['name']} ({$item['symbol']})";
    }

    /**
     * Returns the list of currencies enabled for a company based on user plan.
     * Basic plan: 1 currency (default_currency).
     * Premium/PRO plan: up to 2 currencies (default_currency + secondary_currency).
     */
    public static function enabledForCompany(?CompanySetting $company, bool $isPremium = false): array
    {
        $primary = $company?->default_currency ?: 'PEN';
        if (! isset(static::all()[$primary])) {
            $primary = 'PEN';
        }

        $result = [
            $primary => static::get($primary),
        ];

        if ($isPremium) {
            $secondary = $company?->secondary_currency;
            if ($secondary && $secondary !== $primary && isset(static::all()[$secondary])) {
                $result[$secondary] = static::get($secondary);
            }
        }

        return $result;
    }
}
