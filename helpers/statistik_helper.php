<?php
/**
 * Erstellt  die Daten für das Balkendiagramm 
 * @param array $stats Monatswerte plus Saldo
 * @param array $monthNames  Monatsnamen(1-12)
 * @return array<int, array{
 *     monthShort: string,
 *     saldo: float,
 *     heightPercent: float,
 *     barClass: string
 * }>
 */
function buildChartData(array $stats, array $monthNames): array
{
   //für %-Skalierung
    $maxSaldo = 0.0;
    for ($m = 1; $m <= 12; $m++) {
        $saldo = (float) ($stats[$m]['saldo'] ?? 0);
        $maxSaldo = max($maxSaldo, abs($saldo));
    }

    if ($maxSaldo <= 0) {
        $maxSaldo = 1;// Schutz vor Division durch 0
    }


    $chartData = [];
    for ($m = 1; $m <= 12; $m++) {
        $saldo = (float) ($stats[$m]['saldo'] ?? 0);

        if ($saldo < 0) {
            $barClass = 'bar-negative';
        } elseif ($saldo > 0) {
            $barClass = 'bar-positive';
        } else {
            $barClass = 'bar-null';
        }

        $chartData[] = [
            'monthShort' => substr($monthNames[$m], 0, 3),
            'saldo' => $saldo,
            'heightPercent' => (abs($saldo) / $maxSaldo) * 100,
            'barClass' => $barClass,
        ];
    }

    return $chartData;
}