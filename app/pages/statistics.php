<?php include INCLUDES_PATH . '/head.php'; ?>

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
                        <form method="get" action="<?= BASE_URL . '/statistics' ?>" class="d-flex align-items-end gap-2">
                            <div>
                                <label for="year" class="form-label small text-muted mb-1">Jahr</label>
                                <select name="year" id="year" class="form-select" style="min-width: 140px;">
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
                            <button type="submit" class="btn btn-primary text-nowrap" style="height: 38px;">Anzeigen</button>
                        </form>
                    </div>
                </header>

                <div class="container py-4">
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
            </div>

        </div> <!--row min-vh-100 -->
        <?php include INCLUDES_PATH . '/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div> <!--container-fluig -->
</body>

</html>