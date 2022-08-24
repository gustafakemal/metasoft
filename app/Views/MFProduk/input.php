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

<form name="form-cariproduk">
  <div class="form-row align-items-center">
    <div class="col-6">
      <label class="sr-only" for="cariproduk">Cari Produk</label>
      <input type="text" style="text-transform:uppercase" class="form-control mb-2" name="cariproduk" id="cariproduk" placeholder="Cari Produk Berdasarkan Nama Produk">
    </div>
	<div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Cari</button>
    </div>
    <div class="col-auto">
      <button type="button" class="btn btn-primary add-new mb-2">Buat Baru</button>
    </div>
  </div>
</form>

<div class="dynamic-content">

<div class="tbl-data-product">

<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Segmen</th>
			<th>Pemesan</th>
			<th>Sales</th>
			<th>Dibuat</th>
			<th>Dibuat<br>oleh</th>
			<th>Update</th>
			<th>Diupdate<br>oleh</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

</div>

<form name="csc-form" class="csc-form">
	<div class="msg"></div>
	<div class="form-group row">
		<label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="nama_produk" name="nama_produk">
		</div>
	</div>
	<div class="form-group row">
		<label for="segmen" class="col-sm-2 col-form-label">Segmen <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="segmen" class="form-control" id="segmen">
				<?php foreach ($opsi_segmen as $key => $opsisegmen_item) : ?>
					<option value="<?= $opsisegmen_item->OpsiVal;?>"><?= $opsisegmen_item->OpsiTeks;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="sales" class="col-sm-2 col-form-label">Sales <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="sales" class="form-control" id="sales">
				<!-- <option value="2" selected>--HARDCODED--</option> -->
				<?php foreach ($opsi_sales as $key => $opsisales_item) : ?>
					<option value="<?= $opsisales_item->SalesID;?>"><?= $opsisales_item->SalesName;?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="customer" class="col-sm-2 col-form-label">Pelanggan <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="customer" class="form-control" id="customer">
				<?php foreach ($opsi_customer as $key => $opsicustomer_item) : ?>
					<option value="<?= $opsicustomer_item->NoPemesan;?>"><?= $opsicustomer_item->NamaPemesan;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="contact_person" class="col-sm-2 col-form-label">Contact Person <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="contact_person" name="contact_person">
		</div>
	</div>
	<div class="form-group row">
		<label for="tujuan_kirim" class="col-sm-2 col-form-label">Tujuan Kirim <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="tujuan_kirim" class="form-control" id="tujuan_kirim">
				<?php foreach ($opsi_tujuankirim as $key => $opsitujuankirim_item) : ?>
					<option value="<?= $opsitujuankirim_item->id;?>"><?= $opsitujuankirim_item->tujuan;?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	
	
	
	

<div class="row mt-4">
	<div class="col-12">
		<button type="submit" class="btn btn-primary">Simpan</button>
	</div>
</div>


</form>
<div class="container mt-4">
  <div class="row align-items-start mb-2">
    <div class="col text-left">
	<h5>Part Produk</h5>
    </div>
    <div class="col text-right">
	<button type="button" class="btn btn-success">Cari</button>
	<button type="button" class="btn btn-success">Tambah</button>
    </div>
  </div>
 
</div>
<div class="tbl-data-partproduct">
<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>No</th>
			<th>FGD</th>
			<th>Revisi</th>
			<th>Nama Part Produk</th>
			<th>Kertas</th>
			<th>Flute</th>
			<th>Metalize</th>
			<th>Ukuran</th>
			<th>Dibuat</th>
			<th>Dibuat<br>oleh</th>
			<th>Update</th>
			<th>Diupdate<br>oleh</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

</div>
<div class="container mt-4">
  <div class="row align-items-start mb-2">
    <div class="col text-left">
	<h5>Sisi Part Produk : Nomor FGD - Revisi</h5>
	<h6>Nama Part</h5>
    </div>
    <div class="col text-right">
	<button type="button" class="btn btn-success">Tambah</button>
    </div>
  </div>
 
</div>
<div class="tbl-data-sisipartproduct">
<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>Sisi</th>
			<th>FGD</th>
			<th>Frontside</th>
			<th>Backside</th>
			<th>Special Requirements</th>
			<th>Dibuat</th>
			<th>Dibuat<br>oleh</th>
			<th>Update</th>
			<th>Diupdate<br>oleh</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

</div>
<button type="button" class="btn btn-primary">Simpan</button>
</div>

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id=dataFormLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="nama">Jenis Flute <span class="text-danger">*</span></label>
								<input name="nama" type="text" class="form-control" id="nama">
							</div>
							<div class="form-group">
								<label for="harga">Harga <span class="text-danger">*</span></label>
								<input name="harga" type="number" class="form-control" id="harga" value="0">
							</div>
							<div class="form-group">
								<label for="aktif">Status</label>
								<!-- <div class="form-check">
									<input class="form-check-input" checked="checked" type="radio" name="aktif" id="msJenisFluteAktif" value="Y">
									<label class="form-check-label" for="msJenisFluteAktif">Aktif</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="aktif" id="msJenisFluteNonaktif" value="T">
									<label class="form-check-label" for="msJenisFluteNonaktif">Nonaktif</label>
								</div> -->
								<select name="aktif" class="form-control" id="aktif">
									<option value="Y">Aktif</option>
									<option value="T">Nonaktif</option>
								</select>
							</div>
							
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="loading-indicator"></div>
					<div class="form-navigation">
						<button name="submit" type="submit" class="btn btn-primary btn-save">Simpan</button>
						<button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Batal</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dataDetail" tabindex="-1" aria-labelledby="dataDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataDetailLabel">Data Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<div class="item">
							<label>Jenis Flute</label>
							<div class="custDet nama"></div>
						</div>
						<div class="item">
							<label>Harga</label>
							<div class="custDet harga"></div>
						</div>
						<div class="item">
							<label>Status</label>
							<div class="custDet aktif"></div>
						</div>
						<div class="item">
							<label>Dibuat pada</label>
							<div class="custDet added"></div>
						</div>
						<div class="item">
							<label>Dibuat oleh</label>
							<div class="custDet added_by"></div>
						</div>
						<div class="item">
							<label>Diupdate pada</label>
							<div class="custDet updated"></div>
						</div>
						<div class="item">
							<label>Diupdate oleh</label>
							<div class="custDet updated_by"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button name="cancel" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>