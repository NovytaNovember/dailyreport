<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <!-- Link ke Dashboard -->
            <li class="<?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('dashboard') ?>" aria-expanded="false">
                    <i class="icon icon-app-store"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>


            <!-- CPP Menu -->
            <li>
                <a href="<?= base_url('cpp') ?>" aria-expanded="false">
                    <i class="icon icon-chart-bar-33"></i>
                    <span class="nav-text">CPP</span>
                </a>
            </li>

            <!-- Port Menu -->
            <li>
                <a href="<?= base_url('port') ?>" aria-expanded="false">
                    <i class="icon icon-chart-bar-33"></i>
                    <span class="nav-text">Port</span>
                </a>
            </li>

            <!-- Cetak Laporan Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon icon-chart-bar-33"></i>
                    <span class="nav-text">Cetak Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="<?= base_url('cetak_laporan_cpp'); ?>">Cetak Laporan CPP</a></li>
                    <li><a href="<?= base_url('cetak_laporan_port'); ?>">Cetak Laporan Port</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>