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
            <th>Diinput</th>
            <th>Catatan</th>
            <th>Proses</th>
            <th>Prioritas</th>
            <th>Est</th>
            <th>Smpl</th>
            <th>Action</th>
		</tr>
	</thead>
</table>

</div>

    <!-- Modal -->
    <div class="modal" id="altChoice" tabindex="-1" aria-labelledby="altChoiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="altChoiceLabel">Copy Prospek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">No Prospek</div>
                        <div class="col-8"><strong><span class="no-prospek"></span></strong></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4">Alt</div>
                        <div class="col-8"><strong><span class="alt"></span></strong></div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <a href="#" class="btn btn-info copy-prospek" style="font-size: 14px!important">Copy/Tambah Prospek</a>
                        <a href="#" class="btn btn-primary copy-alt" style="font-size: 14px!important">Copy/Tambah Alternatif</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>