<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>403 Restricted | Anda tidak diperkenankan mengakses resource ini :: Meta</title>
    <meta name="description" content="Meta App.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= site_url('third-party/fontawesome/css/all.min.css'); ?>" />
    <link rel="stylesheet" href="<?= site_url('third-party/bootstrap/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= site_url('css/style.css'); ?>" />

</head>

<body style="background-color: #f4f4f4;">

<div id="page">

    <header class="app-header">
        <div class="sidebar-nav">
            <span data-placement="bottom" class="burger-icon active"><i class="fas fa-bars"></i></span>
        </div>
        <div class="logo">
            <img src="<?= site_url('images/logo.png'); ?>" alt="" />
        </div>
        <div class="top-nav">

        </div>
    </header>

    <div class="page-container">
        <div class="notfound-wrapper">
            <div class="row">
                <div class="col-lg-12 col-sm-12 order-lg-1 order-2">
                    <div class="notfound-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="title">
                        403. Restricted.
                    </div>
                    <p class="ctn">
                        Maaf, Anda tidak diperkenankan mengakses resource <code><?= current_url();?></code> ini.
                    </p>
                    <p>
                        <?= anchor('/', 'Kembali ke halaman utama', ['class' => 'btn btn-primary']);?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>