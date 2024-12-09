<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard'; ?></title>

    <!-- Tambahkan link ke Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <!-- Link ke Owl Carousel dan JQVMap (CSS yang Anda gunakan) -->
    <link rel="stylesheet" href="<?= base_url('focus-2/vendor/owl-carousel/css/owl.carousel.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('focus-2/vendor/owl-carousel/css/owl.theme.default.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('focus-2/vendor/jqvmap/css/jqvmap.min.css'); ?>">

    <!-- Link ke Style Utama -->
    <link rel="stylesheet" href="<?= base_url('focus-2/css/style.css'); ?>">
</head>

<body>
    <div id="main-wrapper">
        <!-- Navigation Header -->
        <div class="nav-header">
            <a href="<?= base_url('dashboard'); ?>" class="brand-logo">
                <img class="logo-abbr" src="<?= base_url('focus-2/images/logo-arutmin.png'); ?>" alt="">
                <img class="logo-compact" src="<?= base_url('focus-2/images/logo-text.png'); ?>" alt="Logo" width="400"
                    height="auto">
                <img class="brand-title" src="<?= base_url('focus-2/images/logo-text.png'); ?>" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <!-- Header Menu -->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <!-- Ikon pencarian menggunakan Bootstrap Icons -->
                                    <i class="bi bi-search"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control" type="search" placeholder="Search"
                                            aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="bi bi-bell"></i> <!-- Ikon bell dari Bootstrap Icons -->
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="bi bi-person"></i></span>
                                            <div class="media-body">
                                                <a href="#">
                                                    <p><strong>Martin</strong> added a <strong>customer</strong>
                                                        successfully.</p>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> <!-- Ikon profil dari Bootstrap Icons -->
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?= base_url('profile'); ?>" class="dropdown-item">
                                        <i class="bi bi-person"></i> Profile
                                        <!-- Ikon profil di dropdown -->
                                    </a>
                                    <a href="<?= base_url('logout'); ?>" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                        <!-- Ikon logout di dropdown -->
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>