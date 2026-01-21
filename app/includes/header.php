<?php
if (!isset($userData) || !is_array($userData)) {
    $userData = $_SESSION['user_data'] ?? [];
}

$isLoggedIn = !empty($userData) && (isset($userData['first_name']) || isset($userData['email']));
$displayName = $isLoggedIn ? ($userData['first_name'] ?? ($userData['email'] ?? 'Account')) : 'Gast';
?>
<header class="bg-white border-bottom">
    <div class="container-fluid px-3 px-lg-4 py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
                <span class="fw-semibold">KostenKlar</span>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        <?= htmlspecialchars((string) $displayName) ?>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (($userData['role'] ?? 'user') !== 'admin'): ?>
                            <li>
                                <a class="dropdown-item" href="<?= page_url('profil') ?>">
                                    Profil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php endif; ?>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= page_url('logout') ?>">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a class="btn btn-outline-secondary btn-sm" href="<?= page_url('startseite') ?>">
                    Startseite
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>