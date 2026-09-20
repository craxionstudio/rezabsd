<?php

namespace App\Support;

use App\Models\TipeUnit;

class TipeProdukSpesifikasi
{
    /**
     * Ordered [label, value] spec rows for the Detail Produk page, shaped
     * per tipe_produk slug. Null/empty optional fields (carport, jumlah
     * lantai) are dropped instead of shown as "-". Always ends with a
     * Status row sourced from the Produk itself (Primary/Secondary), not
     * building readiness.
     *
     * @return array<int, array{label: string, value: string}>
     */
    public static function rows(string $tipeSlug, ?TipeUnit $unit, string $statusProduk): array
    {
        $rows = match ($tipeSlug) {
            'ruko' => [
                ['Luas tanah', self::m2($unit?->luas_tanah)],
                ['Luas bangunan', self::m2($unit?->luas_bangunan)],
                ['Jumlah toilet', self::number($unit?->kamar_mandi)],
                ['Jumlah lantai', self::number($unit?->jumlah_lantai)],
                ['Carport', self::number($unit?->carport)],
            ],
            'apartment' => [
                ['Luas unit', self::m2($unit?->luas_bangunan)],
                ['Tipe kamar', self::tipeKamar($unit?->kamar_tidur)],
                ['Kamar mandi', self::number($unit?->kamar_mandi)],
            ],
            'kavling', 'gudang' => [
                ['Luas tanah', self::m2($unit?->luas_tanah)],
            ],
            default => [
                ['Luas tanah', self::m2($unit?->luas_tanah)],
                ['Luas bangunan', self::m2($unit?->luas_bangunan)],
                ['Kamar tidur', self::number($unit?->kamar_tidur)],
                ['Kamar mandi', self::number($unit?->kamar_mandi)],
                ['Carport', self::number($unit?->carport)],
                ['Jumlah lantai', self::number($unit?->jumlah_lantai)],
            ],
        };

        $rows = array_values(array_filter($rows, fn (array $row) => $row[1] !== null));

        $rows[] = ['Status', $statusProduk === 'primary' ? 'Primary' : 'Secondary'];

        return array_map(fn (array $row) => ['label' => $row[0], 'value' => $row[1]], $rows);
    }

    private static function m2(?int $value): ?string
    {
        return $value === null ? null : "{$value} m²";
    }

    private static function number(?int $value): ?string
    {
        return $value === null ? null : (string) $value;
    }

    private static function tipeKamar(?int $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return $value === 0 ? 'Studio' : "{$value}BR";
    }
}
