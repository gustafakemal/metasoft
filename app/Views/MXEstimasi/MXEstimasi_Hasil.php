<? // List Hasil Estimasi 
   // Berisi list semua hasil estimasi yg statusnya <> 'Selesai' atau belum jadi order
  
   // Dilihat oleh Estimator : Muncul milik semua sales
   // Dilihat oleh Sales : Muncul milik sales tsb

   // Jika buton diklik 
   // Estimator/ Sales Manager lihat MXEstimasi_Detil 
   // Sales lihat MXEstimasi_Ringkas 
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

<div class="tbl-data-listestimasi">

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
            <th>Sales</th>
            <th>Catatan</th>
            <th>Action</th> <!--action hanya buton utk view hasil-->
		</tr>
	</thead>
</table>

</div>

<?= $this->endSection() ?>