<? // Antrian Permintaan Estimasi
   // Dilihat oleh Estimator : Berisi list semua prospek yg minta estimasi, dan estimasinya belum dikerjakan

?>

<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<div class="msg_success"></div>

<div class="tbl-data-queueestimasi">

<table id="dataList" class="table table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
            <th>No</th>
            <th>Prospek</th>
            <th>Alt</th>
            <th>Nama Produk</th>
            <th>Pemesan</th>
            <th>Jumlah</th>
            <th>Diinput</th>
            <th>Catatan</th>
            <th>Action</th>
		</tr>
	</thead>
</table>

</div>

<?= $this->endSection() ?>