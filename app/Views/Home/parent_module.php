<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<div class="page-title-wrapper">
    <h3 class="page-title"><?= $page_title;?></h3>
</div>

<div class="row">
	<div class="col-lg-12 col-sm-12">
		
		<ul>
            <?php foreach ($moduls as $mod) :?>
                <li>
                    <a href="<?= site_url($mod->route);?>">
                        <?= $mod->nama_modul;?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>

	</div>
</div>


<?= $this->endSection()?>