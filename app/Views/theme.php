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
      <div class="floating-msg">
      </div>

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
                            <?php echo (current_user()) ? current_user()->Nama : 'UNAUTHENTICATED' ?>
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
  <li class="<?= (url_is(base_url()) || url_is('home') || url_is('')) ? 'active' : '' ?>">
      <a href="<?= site_url() ?>">
          <i class="fas fa-home text-dark"></i> Dashbor
      </a>
  </li>
  <li class="<?= url_is('customer') ? 'active' : '' ?>">
    <a href="<?= site_url('customer');?>">
    <i class="fas fa-user-circle text-dark"></i> Data Pelanggan
    </a>
  </li>
  <li class="<?= url_is('sales') ? 'active' : '' ?>">
    <a href="<?= site_url('sales');?>">
    <i class="fas fa-handshake text-dark"></i> Data Sales
    </a>
  </li>
  <li class="<?= url_is('mftujuankirim') ? 'active' : '' ?>">
    <a href="<?= site_url('mftujuankirim');?>">
        <i class="fas fa-car-alt text-dark"></i> Tujuan Kirim
    </a>
    </li>
    <li>
      <a class="<?= url_is('mfproduk') ? '' : 'collapsed';?>" href="#" data-toggle="collapse" data-target="#dropdown-mf"
          aria-expanded="<?= url_is('mfproduk') ? 'true' : 'false'; ?>">
          <i class="fas fa-flushed text-dark"></i> Meta Fold
      </a>
      <div id="dropdown-mf" class="collapse<?= url_is('mfproduk') ? ' show' : '';?>"
          data-parent="#mainmenu">
          <ul class="">
              
              <li class="<?= (url_is('mfproduk')) ? 'active' : '';?>">
              <a href="<?= site_url('mfproduk');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Input Produk
                </a>
              </li>
              
              
          </ul>
      </div>
  </li>
  <li>
      <a class="<?= (url_is('mfjeniskertas') || url_is('mfjenistinta') || url_is('mfjenisflute') || url_is('mfprosesfinishing') || url_is('mfprosesmanual') || url_is('mfproseskhusus')) ? '' : 'collapsed';?>" href="#" data-toggle="collapse" data-target="#dropdown-mfmaster"
          aria-expanded="<?= (url_is('mfjeniskertas') || url_is('mfjenistinta') || url_is('mfjenisflute') || url_is('mfprosesfinishing') || url_is('mfprosesmanual') || url_is('mfproseskhusus')) ? 'true' : 'false'; ?>">
          <i class="fas fa-envelope text-dark"></i> Data Meta Fold
      </a>
      <div id="dropdown-mfmaster" class="collapse<?= (url_is('mfjeniskertas') || url_is('mfjenistinta') || url_is('mfjenisflute') || url_is('mfprosesfinishing') || url_is('mfprosesmanual') || url_is('mfproseskhusus')) ? ' show' : '';?>"
          data-parent="#mainmenu">
          <ul class="">
              
              <li class="<?= (url_is('mfjeniskertas')) ? 'active' : '';?>">
              <a href="<?= site_url('mfjeniskertas');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Jenis Kertas
                </a>
              </li>
              <li class="<?= (url_is('mfjenistinta')) ? 'active' : '';?>">
              <a href="<?= site_url('mfjenistinta');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Jenis Tinta
                </a>
              </li>
              <li class="<?= (url_is('mfjenisflute')) ? 'active' : '';?>">
              <a href="<?= site_url('mfjenisflute');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Jenis Flute
                </a>
              </li>
              <li class="<?= (url_is('mfprosesfinishing')) ? 'active' : '';?>">
              <a href="<?= site_url('mfprosesfinishing');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Proses Finishing
                </a>
              </li>
              <li class="<?= (url_is('mfprosesmanual')) ? 'active' : '';?>">
              <a href="<?= site_url('mfprosesmanual');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Proses Manual
                </a>
              </li>
              <li class="<?= (url_is('mfproseskhusus')) ? 'active' : '';?>">
              <a href="<?= site_url('mfproseskhusus');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Proses Khusus
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
    <?php if (url_is('mfproduk') || url_is('mfproduk/*')) : ?>
        <script src="<?= site_url('js/bs-custom-file-input.min.js'); ?>"></script>
        <script src="<?= site_url('js/mfproduk.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('customer')) : ?>
        <script src="<?= site_url('js/customer.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('sales')) : ?>
        <script src="<?= site_url('js/sales.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfjeniskertas')) : ?>
        <script src="<?= site_url('js/mfjeniskertas.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfjenistinta')) : ?>
        <script src="<?= site_url('js/mfjenistinta.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfjenisflute')) : ?>
        <script src="<?= site_url('js/mfjenisflute.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfprosesfinishing')) : ?>
        <script src="<?= site_url('js/mfprosesfinishing.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfprosesmanual')) : ?>
        <script src="<?= site_url('js/mfprosesmanual.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mfproseskhusus')) : ?>
        <script src="<?= site_url('js/mfproseskhusus.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('mftujuankirim')) : ?>
        <script src="<?= site_url('js/mftujuankirim.js'); ?>"></script>
    <?php endif; ?>
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>