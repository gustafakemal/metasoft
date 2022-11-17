<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

    <table id="dataList" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Modul</th>
            <th>Route</th>
            <th>Icon</th>
            <th>Group menu</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
    </table>

<?= $this->endSection();?>