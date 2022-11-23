<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

    <table id="dataRoutes" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
            <th style="width: 25px;">No</th>
            <th>Nama</th>
            <th>Method</th>
            <th>Path</th>
            <th>Kelas</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
    </table>



<?= $this->endSection() ?>