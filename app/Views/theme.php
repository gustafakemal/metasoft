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

        <header class="app-header">
            <div class="sidebar-nav">
                <span data-placement="bottom" class="burger-icon active"><i class="fas fa-bars"></i></span>
            </div>
            <div class="logo">
                <img src="<?= site_url('images/logo.png'); ?>" alt="" />
            </div>
            <div class="top-nav">

                <div class="account-nav dropdown">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="name">
                            <?= (current_user()) ? current_user()->Nama : 'UNAUTHENTICATED' ?>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item">Profil</a>
                            <a href="<?= site_url('logout'); ?>" class="dropdown-item">Logout</a>
                        </div>
                    </button>
                </div>

            </div>
        </header>

        <div class="sidebar">
        <ul class="main-menu accordion" id="mainmenu">
  <li class="<?= (current_url() == site_url()) ? 'active' : '' ?>">
      <a href="<?= site_url() ?>">
          <i class="fas fa-home text-dark"></i> Dashbor
      </a>
  </li>
  
  <li>
      <a href="#" data-toggle="collapse" data-target="#dropdown"
          aria-expanded="<?= (url_is('mail*') || url_is('stats')) ? 'true' : 'false'; ?>">
          <i class="fas fa-envelope text-dark"></i> Master Data
      </a>
      <div id="dropdown" class="collapse"
          data-parent="#mainmenu">
          <ul class="">
              <li class="">
           
                <a href="<?= site_url('customer');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Pelanggan
                </a>
                </li>
              <li class="">
              <a href="<?= site_url('mfjeniskertas');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Jenis Kertas MF
                </a>
              </li>
              <li class="">
              <a href="<?= site_url('mfjenistinta');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Jenis Tinta MF
                </a>
              </li>
          </ul>
      </div>
  </li>
  <li>
      <a href="<?= site_url('logout');?>" onclick="return confirm('Anda yakin untuk Logout?')">
          <i class="fas fa-users text-dark"></i> Logout
      </a>
  </li>
</ul>
        </div>

        <div class="content-wrapper">

            <div class="content">

                <div class="container">
                    <div class="row">
                        <div class="col-12">
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

    <?php if (url_is('customer')) : ?>
        <script src="<?= site_url('js/customer.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfjeniskertas')) : ?>
        <script src="<?= site_url('js/mfjeniskertas.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfjenistinta')) : ?>
        <script src="<?= site_url('js/mfjenistinta.js'); ?>"></script>
    <?php endif; ?>
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>