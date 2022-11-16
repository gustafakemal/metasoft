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
        <ul class="main-menu accordion" id="mainmenu">
  <li class="<?= (url_is(base_url()) || url_is('home') || url_is('')) ? 'active' : '' ?>">
      <a href="<?= site_url() ?>">
          <div class="icon">
            <i class="fas fa-home"></i>
          </div>
          <div class="caption">Dashbor
          </div>
      </a>
  </li>
  <li class="<?= url_is('master/customer*') ? 'active' : '' ?>">
    <a href="<?= site_url('master/customer');?>">
          <div class="icon">
            <i class="fas fa-user-circle"></i>
          </div>
          <div class="caption">
            Data Pelanggan
          </div>
    </a>
  </li>
  <li class="<?= url_is('master/sales*') ? 'active' : '' ?>">
    <a href="<?= site_url('master/sales');?>">
      <div class="icon">
            <i class="fas fa-handshake"></i>
          </div>
          <div class="caption">
            Data Sales
          </div>
    </a>
  </li>
  <li class="<?= url_is('master/destination*') ? 'active' : '' ?>">
    <a href="<?= site_url('master/destination');?>">
        
        <div class="icon">
            <i class="fas fa-car-alt"></i>
          </div>
          <div class="caption">
            Tujuan Kirim
          </div>
    </a>
    </li>
    <li>
      <a class="<?= url_is('mfproduk') ? '' : 'collapsed';?>" href="#" data-toggle="collapse" data-target="#dropdown-mf"
          aria-expanded="<?= url_is('mfproduk') ? 'true' : 'false'; ?>">
          
          <div class="icon">
            <i class="fas fa-flushed"></i>
          </div>
          <div class="caption">
            Meta Fold
          </div>
      </a>
      <div id="dropdown-mf" class="collapse<?= (url_is('mfproduk') || url_is('mfproduk/*') || url_is('MFProduk') || url_is('MFProduk/*') || url_is('mfpartproduk') || url_is('partproduk') || url_is('partproduk/*')) ? ' show' : '';?>"
          data-parent="#mainmenu">
          <ul class="">
              
              <li class="<?= (url_is('mfproduk') || url_is('mfproduk/*') || url_is('MFProduk') || url_is('MFProduk/*')) ? 'active' : '';?>">
              <a href="<?= site_url('mfproduk');?>">
                    <i class="fas fa-arrow-circle-right text-dark"></i> Data Produk
                </a>
              </li>

              <li class="<?= (url_is('mfpartproduk') || url_is('partproduk/*')) ? 'active' : '';?>">
                  <a href="<?= site_url('mfpartproduk');?>">
                      <i class="fas fa-arrow-circle-right text-dark"></i> Data Part Produk
                  </a>
              </li>
              
              
          </ul>
      </div>
  </li>
  <li>
      <a class="<?= (url_is('master/kertas*') || url_is('master/tinta*') || url_is('master/flute*') || url_is('master/finishing*') || url_is('master/manual*') || url_is('master/khusus*')) ? '' : 'collapsed';?>" href="#" data-toggle="collapse" data-target="#dropdown-mfmaster"
          aria-expanded="<?= (url_is('master*')) ? 'true' : 'false'; ?>">
          <div class="icon">
            <i class="fas fa-envelope"></i>
          </div>
          <div class="caption">
            Data Meta Fold
          </div>
      </a>
      <div id="dropdown-mfmaster" class="collapse<?= (url_is('master/kertas*') || url_is('master/tinta*') || url_is('master/flute*') || url_is('master/finishing*') || url_is('master/manual*') || url_is('master/khusus*')) ? ' show' : '';?>"
          data-parent="#mainmenu">
          <ul class="">
              
              <li class="<?= (url_is('master/kertas*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/kertas');?>">
                    <i class="fas fa-arrow-circle-right"></i> Jenis Kertas
                </a>
              </li>
              <li class="<?= (url_is('master/tinta*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/tinta');?>">
                    <i class="fas fa-arrow-circle-right"></i> Jenis Tinta
                </a>
              </li>
              <li class="<?= (url_is('master/flute*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/flute');?>">
                    <i class="fas fa-arrow-circle-right"></i> Jenis Flute
                </a>
              </li>
              <li class="<?= (url_is('master/finishing*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/finishing');?>">
                    <i class="fas fa-arrow-circle-right"></i> Proses Finishing
                </a>
              </li>
              <li class="<?= (url_is('master/manual*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/manual');?>">
                    <i class="fas fa-arrow-circle-right"></i> Proses Manual
                </a>
              </li>
              <li class="<?= (url_is('master/khusus*')) ? 'active' : '';?>">
              <a href="<?= site_url('master/khusus');?>">
                    <i class="fas fa-arrow-circle-right"></i> Proses Khusus
                </a>
              </li>
              
          </ul>
      </div>
  </li>
  <li>
      <a href="<?= site_url('logout');?>" onclick="return confirm('Anda yakin untuk Logout?')">
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <div class="caption">
            Logout
          </div>
      </a>
  </li>
</ul>
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
    <?php if (url_is('customer*')) : ?>
        <script src="<?= site_url('js/customer.js'); ?>"></script>
    <?php endif; ?>
    <?php if (url_is('sales*')) : ?>
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
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>