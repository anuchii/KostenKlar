<?php

require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/transactions.php';
require_once HELPERS_PATH . '/statistik_helper.php';


if (!isset($userData) || !is_array($userData)) {
    $userData = $_SESSION['user_data'] ?? [];
}

$userId = $userData['user_id'] ?? null;

$selectedYear = isset($request['parameters']['GET']['year'])
    ? (int) $request['parameters']['GET']['year']
    : (int) date('Y');

$stats = getMonthlySumByUserIdAndYear($userId, $selectedYear, $pdo);
$statsPie = getPieChartData($selectedYear, $userId, $pdo);

$monthNames = [
    1 => 'Januar',
    2 => 'Februar',
    3 => 'März',
    4 => 'April',
    5 => 'Mai',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'August',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Dezember',
];


$chartData = buildChartData($stats, $monthNames);
$pieData = buildPieChartData($statsPie);

$pieGradient = $pieData['gradient'] ?? 'conic-gradient(#e9ecef 0% 100%)';
$pieLegendItems = $pieData['legend'] ?? [];

render('statistics', [
    'pageTitle' => 'Statistik',
    'userData' => $userData,
    'chartData' => $chartData,
    'pieData' => $pieData,
    'pieGradient' => $pieGradient,
    'pieLengendItems' => $pieLegendItems,
    'selectedYear' => $selectedYear
]);