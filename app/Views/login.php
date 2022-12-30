<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login :: Metaform</title>
    <meta name="description" content="Metaform app">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= site_url('favicon.ico');?>" />
    <link rel="stylesheet" href="<?= site_url('third-party/fontawesome/css/all.min.css'); ?>" />

    <link rel="stylesheet" href="<?= site_url('third-party/bootstrap/css/bootstrap.min.css'); ?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('third-party/DataTables/datatables.min.css');?>" />

    <link rel="stylesheet" type="text/css" href="<?= site_url('css/style.css'); ?>" />
</head>

<body style="background-color: #f9f9f9">

    <div id="page">

        <div class="page-container">

            <div class="login-wrapper">

                <div class="logo">
                    <img src="<?= site_url('images/logo_login.png');?>" alt="" />
                </div>

                <div class="login-box">
                    <?php //echo form_open('auth/verify');?>
                    <form name="login">
                        <h2 class="title">Login</h2>

                        <div class="error_msg"></div>
                        
                        <?php if(session()->has('error')) : ?>
                        <div class="alert alert-danger"><?= session()->get('error');?></div>
                        <?php endif;?>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input name="username" type="text" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>

                <div class="copyright">
                    &copy; <?= date("Y") ?> KG of Manufacture
                </div>

            </div>

        </div>

    </div>

    <!-- SCRIPTS -->

    <script src="<?= site_url('third-party/jquery/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?= site_url('third-party/DataTables/datatables.min.js');?>"></script>
    <script type="text/javascript"
        src="<?= site_url('third-party/DataTables/DataTables-1.11.3/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/popper.min.js'); ?>"></script>
    <script src="<?= site_url('third-party/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript">
        const HOST = "<?= base_url();?>"
    </script>

    <?php if(url_is('customer')) : ?>
        <script src="<?= site_url('js/customer.js'); ?>"></script>
    <?php endif;?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= site_url('js/custom.js'); ?>"></script>
    <!-- -->

</body>

</html>