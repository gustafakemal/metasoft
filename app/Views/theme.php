<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?=$this->renderSection('title');?> :: Metaform</title>
    <meta name="description" content="Metaform app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?=site_url('favicon.ico');?>" />
    <link rel="stylesheet" href="<?=site_url('third-party/fontawesome/css/all.min.css');?>" />

    <link rel="stylesheet" href="<?=site_url('third-party/bootstrap/css/bootstrap.min.css');?>" />
    <link rel="stylesheet" href="<?=site_url('third-party/bootstrap/css/bootstrap4-toggle.min.css');?>" />

    <link rel="stylesheet" type="text/css" href="<?=site_url('third-party/DataTables/datatables.min.css');?>" />

    <link rel="stylesheet" type="text/css" href="<?=site_url('css/style.css');?>" />
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
            <img src="<?=site_url('images/logo.png');?>" alt="" />
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
                    <a href="<?=site_url('logout');?>" class="dropdown-item">Logout</a>
                </div>
            </div>

        </div>
    </header>

    <div class="sidebar">

        <?=$main_menu;?>

    </div>

    <div class="content-wrapper">

        <div class="content">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?=$breadcrumbs ?? '';?>
                        <?=$this->renderSection('content')?>
                    </div>
                </div>
            </div>

        </div>

        <footer class="app-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright">
                            &copy; <?=date("Y")?> KG of Manufacture
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>

</div>

<!-- SCRIPTS -->

<script src="<?=site_url('third-party/jquery/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?=site_url('third-party/DataTables/datatables.min.js');?>"></script>
<script type="text/javascript" src="<?=site_url('third-party/DataTables/DataTables-1.11.3/js/dataTables.bootstrap4.min.js');?>"></script>
<script src="<?=site_url('third-party/bootstrap/js/popper.min.js');?>"></script>
<script src="<?=site_url('third-party/bootstrap/js/bootstrap.min.js');?>"></script>
<script type="text/javascript">
    const HOST = "<?=base_url();?>"
</script>

<?php if (url_is('mfpartproduk') || url_is('mfpartproduk/*') || url_is('partproduk') || url_is('partproduk/*')): ?>
    <script src="<?=site_url('js/bs-custom-file-input.min.js');?>"></script>
    <script src="<?=site_url('js/mfpartproduk.js');?>"></script>
<?php endif;?>
<?php if (url_is('produk*') || url_is('MFProduk/*')): ?>
    <script src="<?=site_url('js/bs-custom-file-input.min.js');?>"></script>
    <script src="<?=site_url('js/mfproduk.js');?>"></script>
<?php endif;?>
<?php if (url_is('pelanggan*')): ?>
    <script type="module" src="<?=site_url('js/customer.js');?>"></script>
<?php endif;?>
<?php if (url_is('sales*')): ?>
    <script type="module" src="<?=site_url('js/sales.js');?>"></script>
<?php endif;?>
<?php if (url_is('jeniskertas*')): ?>
    <script type="module" src="<?=site_url('js/mfjeniskertas.js');?>"></script>
<?php endif;?>
<?php if (url_is('jenistinta*')): ?>
    <script type="module" src="<?=site_url('js/mfjenistinta.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxjenistinta*')): ?>
    <script type="module" src="<?=site_url('js/mxjenistinta.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxjenisfilm*')): ?>
    <script type="module" src="<?=site_url('js/mxjenisfilm.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxjeniskonten*')): ?>
    <script type="module" src="<?=site_url('js/mxjeniskonten.js');?>"></script>
<?php if (url_is('mxsolventtinta*')): ?>
    <script type="module" src="<?=site_url('js/mxsolventtinta.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxaksesori*')): ?>
    <script type="module" src="<?=site_url('js/mxaksesori.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxadhesive*')): ?>
    <script type="module" src="<?=site_url('js/mxadhesive.js');?>"></script>
<?php endif;?>
<?php if (url_is('mxkonstanta*')): ?>
    <script type="module" src="<?=site_url('js/mxkonstanta.js');?>"></script>
<?php endif;?>
<?php if (url_is('jenisflute*')): ?>
    <script type="module" src="<?=site_url('js/mfjenisflute.js');?>"></script>
<?php endif;?>
<?php if (url_is('prosesfinishing*')): ?>
    <script type="module" src="<?=site_url('js/mfprosesfinishing.js');?>"></script>
<?php endif;?>
<?php if (url_is('prosesmanual*')): ?>
    <script type="module" src="<?=site_url('js/mfprosesmanual.js');?>"></script>
<?php endif;?>
<?php if (url_is('proseskhusus*')): ?>
    <script type="module" src="<?=site_url('js/mfproseskhusus.js');?>"></script>
<?php endif;?>
<?php if (url_is('tujuankirim*')): ?>
    <script type="module" src="<?=site_url('js/mftujuankirim.js');?>"></script>
<?php endif;?>
<?php if (url_is('setting/*')): ?>
    <script type="module" src="<?=site_url('js/setting.js');?>"></script>
<?php endif;?>
<?php if (url_is('inputprospek*') || url_is('listprospek*')): ?>
    <script type="module" src="<?=site_url('js/mxprospect.js');?>"></script>
    <script src="<?=site_url('third-party/bootstrap/js/bootstrap4-toggle.min.js');?>"></script>
<?php endif;?>
<script src="<?=site_url('js/custom.js');?>"></script>

<!-- -->

</body>

</html>