<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->renderSection('title'); ?> :: Metaform</title>
    <meta name="description" content="Metaform app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('favicon.ico'); ?>" />
    <link rel="stylesheet" href="<?= site_url('third-party/fontawesome/css/all.min.css'); ?>" />

    <link rel="stylesheet" href="<?= site_url('third-party/bootstrap/css/bootstrap.min.css'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('third-party/DataTables/datatables.min.css'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('css/style.css'); ?>" />
</head>

<body>

    <div id="page">
      <div class="overlay"></div>
      <div class="floating-msg">
      </div>

        <header class="app-header">
            <div class="sidebar-nav">
                <span data-placement="bottom" class="burger-icon active"><i class="fas fa-bars"></i></span>
            </div>
            <div class="sidebar-mob">
                <span data-placement="bottom" class="burger-icon active"><i class="fas fa-bars"></i></span>
            </div>
            <div class="logo">
                <img src="<?= site_url('images/logo.png'); ?>" alt="" />
            </div>
            <div class="top-nav">
                <div class="account-nav dropdown">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="icon">
                            <i class="far fa-user-circle"></i>
                        </div>
                        <div class="name"><?php echo (current_user()) ? current_user()->Nama : 'UNAUTHENTICATED' ?></div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">Profil</a>
                        <a href="<?= site_url('logout'); ?>" class="dropdown-item">Logout</a>
                    </div>
                </div>

            </div>
        </header>

        <div class="sidebar">

            <?= $main_menu;?>


        </div>

        <div class="content-wrapper">

            <div class="content">

                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <?= $breadcrumbs ?? '';?>
                            <?= $this->renderSection('content') ?>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="app-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="copyright">
                                &copy; <?= date("Y") ?> KG of Manufacture
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <!-- SCRIPTS -->

    <script src="<?= site_url('third-party/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= site_url('third-party/DataTables/datatables.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= site_url('third-party/DataTables/DataTables-1.11.3/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="<?= site_url('third-party/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
        const HOST = "<?= base_url(); ?>"
    </script>
    <?php if (url_is('mfpartproduk') || url_is('mfpartproduk/*') || url_is('partproduk') || url_is('partproduk/*')) : ?>
        <script src="<?= site_url('js/bs-custom-file-input.min.js'); ?>"></script>
        <script src="<?= site_url('js/mfpartproduk.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfproduk') || url_is('MFProduk') || url_is('mfproduk/*') || url_is('MFProduk/*')) : ?>
        <script src="<?= site_url('js/bs-custom-file-input.min.js'); ?>"></script>
        <script src="<?= site_url('js/mfproduk.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/customer*')) : ?>
        <script src="<?= site_url('js/customer.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/sales*')) : ?>
        <script src="<?= site_url('js/sales.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/kertas*')) : ?>
        <script src="<?= site_url('js/mfjeniskertas.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/tinta*')) : ?>
        <script src="<?= site_url('js/mfjenistinta.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/flute*')) : ?>
        <script src="<?= site_url('js/mfjenisflute.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/finishing*')) : ?>
        <script src="<?= site_url('js/mfprosesfinishing.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/manual*')) : ?>
        <script src="<?= site_url('js/mfprosesmanual.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/khusus*')) : ?>
        <script src="<?= site_url('js/mfproseskhusus.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('master/destination*')) : ?>
        <script src="<?= site_url('js/mftujuankirim.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('setting*')) : ?>
        <script src="<?= site_url('js/setting.js'); ?>"></script>
    <?php endif; ?>
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>