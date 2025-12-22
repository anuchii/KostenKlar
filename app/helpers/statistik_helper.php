<?php
/**
 * Erstellt  die Daten für das Balkendiagramm 
 * @param array $stats Monatswerte pro ausgewählten Jahr 
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


/**
 * Erstellt die Daten für das Kuchendiagramm (PieChart).
 * @param array $statsPie  Kategorien und Summen der Ausgaben.
 *  Erwartete Struktur:
 *  [
 *      'category' => string[],        -> Namen der Kategorien
 *      'totalExpenses' => float[]     -> Ausgaben pro Kategorie
 *  ]
 * 
 * @return array{
 *     gradient: string,               -> CSS conic-gradient für das PieChart
 *     legend: array<int, array{
 *         label: string,              -> Kategoriename
 *         value: float,               ->Betrag
 *         percent: float,             -> Prozentanteil
 *         color: string               -> Farbe im Diagramm
 *     }>,
 *     total: float                    -> Gesamtausgaben
 */
function buildPieChartData(array $statsPie): array
{
    $labels = $statsPie['category'] ?? [];
    $valuesRaw = $statsPie['totalExpenses'] ?? [];


    $values = [];
    foreach ($valuesRaw as $v) {
        $values[] = (float) $v;
    }


    $total = array_sum($values);
    if ($total <= 0) {
           return [
        'gradient' => 'conic-gradient(#e9ecef 0% 100%)',
        'legend' => [],
        'total' => 0.0,
    ];
    }

    $colors = [
         '#EEB422', 
        '#4e79a7', 
        '#59a14f', 
        '#b07aa1', 
        '#76b7b2', 
        '#e15759', 
        '#2f4b7c', 
    ];

    $gradient = 'conic-gradient(#e9ecef 0% 100%)';
    $legend = [];

    if ($total > 0 && count($values) > 0) {
        $current = 0.0;
        $segments = [];

        foreach ($values as $i => $value) {
            if ($value <= 0) {
                continue;
            }

            $percent = ($value / $total) * 100.0;
            $start = $current;
            $end = $current + $percent;
            $color = $colors[$i % count($colors)];


            $segments[] = sprintf('%s %.4f%% %.4f%%', $color, $start, $end);
            $current = $end;


            $label = $labels[$i] ?? ('Kategorie ' . ($i + 1));
            $legend[] = [
                'label' => (string) $label,
                'value' => (float) $value,
                'percent' => (float) $percent,
                'color' => (string) $color,
            ];
        }

        if (count($segments) > 0) {
            $gradient = 'conic-gradient(' . implode(', ', $segments) . ')';
        }
    }

    return [
        'gradient' => $gradient,
        'legend' => $legend,
        'total' => (float) $total,
    ];
}