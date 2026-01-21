<aside id="sidebar" class="col-12 col-lg-2 bg-white border-end p-0">
    <div id="sidebarCollapse" class="collapse d-lg-block">
        <nav class="pt-4">
            <ul class="nav nav-pills flex-column gap-1 px-2">
                <li class="nav-item">
                    <a href="<?= page_url('user_dashboard') ?>" class="nav-link active d-flex align-items-center gap-2">
                        <i class="bi bi-speedometer2" aria-hidden="true"></i>
                        Übersicht
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= page_url('new_transaction') ?>"
                        class="nav-link text-muted d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle" aria-hidden="true"></i>
                        Neue Buchung
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= page_url('statistik') ?>" class="nav-link text-muted d-flex align-items-center gap-2">
                        <i class="bi bi-bar-chart" aria-hidden="true"></i>
                        Statistiken
                    </a>
                </li>
                <hr class="my-3">
                <li class="nav-item">
                    <a href="<?= page_url('profil') ?>" class="nav-link text-muted d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle" aria-hidden="true"></i>
                        Profil
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>