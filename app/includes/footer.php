<footer class="bg-white border-top py-3 fixed-bottom">
    <div class="container-fluid px-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <!--Copyright + Name -->
        <div class="text-muted small mb-2 mb-md-0">
            &copy; <?= date('Y') ?> KostenKlar
        </div>
        <!--Links: datenschutz, impressum-->
        <div class="small">
            <a href="<?=page_url('impressum')?>" class="text-muted me-3 text-decoration-none">Impressum</a>
            <a href="<?=page_url('datenschutz')?>" class="text-muted text-decoration-none">Datenschutz</a>
        </div>
    </div>
</footer>