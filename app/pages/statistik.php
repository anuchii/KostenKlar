<?php
require_once HELPERS_PATH . '/url.php';
require_once CONFIG_PATH . '/db_config.php';
require_once HELPERS_PATH . '/transactions.php';
require_once HELPERS_PATH . '/statistik_helper.php';
require_once HELPERS_PATH . '/functions.php';

require_login_or_redirect('login');
require_role_or_abort('user');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($userData) || !is_array($userData)) {
    $userData = $_SESSION['user_data'] ?? [];
}
$userId = $userData['user_id'] ?? null;
$dbError = '';

$selectedYear = isset($_GET['year'])
    ? (int) $_GET['year']
    : (int) date('Y');

$stats = [];
$statsPie = [];
try {
    $stats = getMonthlySumByUserIdAndYear((int) $userId, $selectedYear, $pdo);
    $statsPie = getPieChartData($selectedYear, (int) $userId, $pdo);
} catch (Throwable $e) {
    $stats = [];
    $statsPie = [];
    $dbError = 'Statistik konnte nicht geladen werden.';
}

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

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Statistiken</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= asset_url('/css/statistik.css') ?>">
    <link rel="icon" type="image/png" href="<?= asset_url('images/logo_schnell3.png') ?>">
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row min-vh-100">
            <?php include INCLUDES_PATH . '/sidebar.php'; ?>
            <div class="col-12 col-lg-10 p-0">
                <?php include INCLUDES_PATH . '/header.php'; ?>
                <!-- Statistik Header -->
                <header class="py-4 px-3 px-lg-4 border-bottom bg-white">
                    <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3">
                        <div>
                            <h1 class="h3 mb-1">Statistik</h1>
                            <p class="text-muted mb-0">Überblick über Einnahmen und Ausgaben.</p>
                        </div>
                        <!-- Jahr-Auswahl -->
                        <form method="get" action="<?= page_url('statistik') ?>" class="d-flex align-items-end gap-2">
                            <input type="hidden" name="page" value="statistik">
                            <div>
                                <label for="year" class="form-label small text-muted mb-1">Jahr</label>
                                <select name="year" id="year" class="form-select statistik-year-select">
                                    <?php
                                    $currentYear = (int) date('Y');
                                    for ($y = $currentYear; $y >= $currentYear - 5; $y--):
                                        ?>
                                        <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>>
                                            <?= $y ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <button type="submit"
                                class="btn btn-primary text-nowrap statistik-year-btn">Anzeigen</button>
                        </form>
                    </div>
                </header>
                <div class="container py-4">
                    <?php if (!empty($dbError)): ?>
                        <div class="alert alert-warning mb-3" role="alert">
                            <?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>
                    <div class="row g-3">
                        <div class="col-12 col-lg-7">
                            <div class="card shadow-sm rounded-3 h-100">
                                <div class="card-header bg-white">
                                    <strong>Monatsverlauf</strong>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <?php foreach ($chartData as $item): ?>
                                            <div class="chart-item">
                                                <div class="vertical-bar <?= $item['barClass'] ?>"
                                                    style="height: <?= $item['heightPercent'] ?>%;"></div>
                                                <small><?= $item['monthShort'] ?></small>
                                                <small class="text-muted">
                                                    <?= number_format($item['saldo'], 2, ',', '.') ?> €
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="card shadow-sm rounded-3 h-100">
                                <div class="card-header bg-white"><strong>Kategorien</strong></div>
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div
                                        class="d-flex flex-column flex-sm-row gap-4 align-items-center justify-content-center w-100">
                                        <div class="pie"
                                            style="background: <?= htmlspecialchars($pieGradient, ENT_QUOTES, 'UTF-8') ?>;">
                                        </div>
                                        <ul class="list-unstyled mb-0 statistik-legend">
                                            <?php if (empty($pieLegendItems)): ?>
                                                <li class="text-muted">Keine Daten für <?= (int) $selectedYear ?> vorhanden.
                                                </li>
                                            <?php else: ?>
                                                <?php foreach ($pieLegendItems as $item): ?>
                                                    <li class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="statistik-legend-swatch"
                                                            style="width: 12px; height: 12px; background: <?= htmlspecialchars($item['color'], ENT_QUOTES, 'UTF-8') ?>; display:inline-block; border-radius: 2px;"></span>
                                                        <span class="small">
                                                            <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?>
                                                            — <?= number_format((float) $item['value'], 2, ',', '.') ?> €
                                                            (<?= number_format((float) $item['percent'], 1, ',', '.') ?>%)
                                                        </span>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include INCLUDES_PATH . '/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>