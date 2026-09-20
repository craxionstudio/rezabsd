<?php

namespace App\Support;

class Rupiah
{
    /**
     * Format singkat ala mockup: "Rp 850 juta", "Rp 1,4 miliar".
     * Mirrors resources/js/lib/format.js#formatHargaSingkat.
     */
    public static function singkat(int $value): string
    {
        if ($value >= 1_000_000_000) {
            $miliar = round($value / 1_000_000_000, 1);

            return 'Rp '.str_replace('.', ',', (string) $miliar).' miliar';
        }

        if ($value >= 1_000_000) {
            $juta = round($value / 1_000_000);

            return "Rp {$juta} juta";
        }

        return 'Rp '.number_format($value, 0, ',', '.');
    }
}
