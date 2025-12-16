<?php
session_start();
require_once "transactions.php";
require_once __DIR__ . '/config/db_config.php';
require_once __DIR__ . '/helpers/statistik_helper.php';

$user_id = $_SESSION["user_data"]["user_id"];
$selectedYear = isset($_GET['year'])
    ? (int) $_GET['year']
    : (int) date('Y');

$stats = getMonthlySumByUserIdAndYear($user_id, $selectedYear, $pdo);
$statsPie = getPieChartData($selectedYear, $user_id, $pdo);

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
    <title>Statistik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/KostenKlar/assets/css/statistik.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100">
            <?php include 'sidebar.php'; ?>
            <div class="col-12 col-lg-10 p-0">
                <?php include 'header.php'; ?>

                <header class="py-4 border-bottom p-3">
                    <h2> Statistik</h2>
                    <p class="text-muted mb-0">Überblick über Einnahmen und Ausgaben</p>
                </header>

                <section class="py-4 p-3">
                    <h4 class="text-muted"> Hier kannst du den Verlauf über mehrere Monate anschauen.</h4>
                </section>

                <div class="row g-3 px-3 pb-4">
                    <div class="col-12 col-lg-7">
                        <div class="card shadow-sm h-100">
                            <div class="card-header">
                                <!--Dropdown für Das Jahr-->
                                <form method="get" class="d-flex align-items-end gap-2 mt-2" style="max-width: 200px; ">
                                    <select name="year" id="year" class="form-select flex-grow-1">
                                        <!-- kein JS: Auswahl + Button -->
                                        <!-- onchange = "this.form.submit"-->

                                        <?php
                                        $currentYear = (int) date('Y');
                                        for ($y = $currentYear; $y >= $currentYear - 5; $y--):
                                            ?>
                                            <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>>
                                                <?= $y ?>
                                            </option>
                                        <?php endfor; ?>


                                    </select>
                                    <button type="submit"
                                        class="btn btn-sm btn-warning text-nowrap mt-2 mb-1">Anzeigen</button>
                                </form>
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
                        <div class="card shadow-sm h-100">
                            <div class="card-header">Kategorien</div>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div
                                    class="d-flex flex-column flex-sm-row gap-4 align-items-center justify-content-center w-100">
                                    <div class="pie"
                                        style="background: <?= htmlspecialchars($pieGradient, ENT_QUOTES, 'UTF-8') ?>;">
                                    </div>

                                    <ul class="list-unstyled mb-0" style="min-width: 180px;">
                                        <?php if (empty($pieLegendItems)): ?>
                                            <li class="text-muted">Keine Daten für <?= (int) $selectedYear ?> vorhanden.
                                            </li>
                                        <?php else: ?>
                                            <?php foreach ($pieLegendItems as $item): ?>
                                                <li class="d-flex align-items-center gap-2 mb-2">
                                                    <span
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

        </div> <!--row min-vh-100 -->
        <?php include __DIR__ . '/includes/footer.php'; ?>
    </div> <!--container-fluig -->
</body>

</html>