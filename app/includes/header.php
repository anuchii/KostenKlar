<header class="bg-white border-bottom">

    <div class="container-fluid px-3 px-lg-4 py-2">
        <div class="d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center gap-2">
                <span class="fw-semibold">KostenKlar</span>
            </div>


            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($userData['first_name']) ?>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="<?= page_url('profil') ?>">
                            Profil
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="<?= page_url('logout') ?>">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header>