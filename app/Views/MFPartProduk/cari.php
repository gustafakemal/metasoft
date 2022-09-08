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

<form name="form-caripartproduk">
  <div class="form-row align-items-center">
    <div class="col-6">
      <label class="sr-only" for="caripartproduk">Cari Part Produk</label>
      <input type="text" style="text-transform:uppercase" class="form-control mb-2" name="caripartproduk" id="caripartproduk" placeholder="Cari Produk Berdasarkan Nomor FGD atau Nama Part Produk">
    </div>
	<div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Cari</button>
    </div>
    <div class="col-auto">
      <a type="button" class="btn btn-primary add-new mb-2" href="<?= site_url('partproduk/add');?>">Buat Baru</a>
    </div>
  </div>
</form>

<div class="dynamic-content">

<div class="tbl-data-partproduct">

<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>No</th>
			<th>FGD</th>
			<th>Revisi</th>
			<th>Nama Part</th>
			<th>Kertas</th>
			<th>Flute</th>
			<th>Metalizes</th>
			<th>Ukuran (mm)</th>
			<th>Dibuat</th>
			<th>Dibuat<br>oleh</th>
			<th>Update</th>
			<th>Diupdate<br>oleh</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

</div>






</div>



<?= $this->endSection() ?>