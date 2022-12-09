<? // List Prospek Metaflex 

   // Defaultnya tampilkan prospek milik Sales yg Login, yg statusnya belum jadi Order
   // Hasil Cari tampilkan prospek apapun yg nama Produknya like parameter
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

<form name="form-cariprospek">
    <div class="form-row align-items-center">
        <div class="col-6">
            <label class="sr-only" for="cariprospek">Cari Prospek</label>
            <input type="text" style="text-transform:uppercase" class="form-control mb-2" name="cariprospek" id="cariprospek" placeholder="Cari Prospek Berdasarkan Nama Produk">
        </div>
	    <div class="col-auto">
            <button title="Cari" type="submit" class="btn btn-primary mb-2">Cari</button>
        </div>
    </div>
</form>

<div class="tbl-data-listprospek">

<table id="dataList" class="table table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
            <th>No</th>
            <th>Prospek</th>
            <th>Alt</th>
            <th>Nama Produk</th>
            <th>Pemesan</th>
            <th>Jumlah</th>
            <th>Area</th>
            <th>Diinput</th>
            <th>Catatan</th>
            <th>Status</th>
            <th>Proses</th>
            <th>Action</th>
		</tr>
	</thead>
</table>

</div>

<?= $this->endSection() ?>