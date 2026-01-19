<aside id="sidebar" class="col-12 col-lg-2 bg-white border-end p-0">
    <nav class="pt-4">

        <ul class="nav nav-pills flex-column gap-1 px-2">

            <li class="nav-item">
                <a href="<?= BASE_URL . '/dashboard' ?>"
                    class="nav-link active d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2"></i>
                    Übersicht
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= BASE_URL . '/transaction/new' ?>"
                    class="nav-link text-muted d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    Neue Buchung
                </a>
            </li>


            <li class="nav-item">
                <a href="<?= BASE_URL . '/statistik' ?>"
                    class="nav-link text-muted d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart"></i>
                    Statistiken
                </a>
            </li>

            <hr class="my-3">

            <li class="nav-item">
                <a href="<?= BASE_URL . '/profil' ?>"
                    class="nav-link text-muted d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle"></i>
                    Profil
                </a>
            </li>

        </ul>
    </nav>
</aside>