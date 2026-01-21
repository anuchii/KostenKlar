<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= page_url('startseite') ?>">
            <img src="<?= asset_url('images/logo_schnell3.png') ?>" alt="KostenKlar" width="32" height="32"
                class="rounded">
            <span class="fw-semibold">KostenKlar</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#kkNav"
            aria-controls="kkNav" aria-expanded="false" aria-label="Menü">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="kkNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="btn btn-outline-secondary ms-lg-2"
                        href="<?= page_url('login') ?>">Login</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="<?= page_url('register') ?>">Registrieren</a></li>
            </ul>
        </div>
    </div>
</nav>