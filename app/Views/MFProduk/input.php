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

<div class="tbl-data-product show">

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
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#cariPart">
	<i class="fas fa-solid fa-search text-light"></i>&nbsp;Cari
</button>
	<a href="MFPartProduk/addPartProduct" type="button" class="btn btn-success"><i class="fa fa-plus-circle text-light"></i>&nbsp;Tambah</a>
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
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#dataFormSisi">
	<i class="fa fa-plus-circle text-light"></i>&nbsp;Tambah Sisi
</button>
    </div>
  </div>
 
</div>
<div class="tbl-data-sisipartproduct">
<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>Sisi</th>
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
</div>

<!-- Modal -->

<div class="modal fade modalForm" id="dataFormSisi" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel">Sisi Part Produk<br>Nama Part Produk</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<label for="fgd" class="col-sm-2 col-form-label">No FGD</span></label>
						<div class="col-sm-4">
						<!-- <input type="text" class="form-control" id="tfgd" name="tfgd" disabled><input type="hidden" class="form-control" id="fgd" name="fgd"> -->
						<input type="text" class="form-control" id="fgd" name="fgd" readonly>
						</div>
						<label for="trevisi" class="col-sm-2 col-form-label">Revisi</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="trevisi" name="trevisi" disabled><input type="hidden" class="form-control" id="revisi" name="revisi">
						</div>
					</div>
					<div class="row">
						<label for="sisi" class="col-sm-2 col-form-label">Sisi</span></label>
						<div class="col-sm">
						<input type="text" class="form-control" id="sisi" name="sisi">
						</div>
						<label for="frontside" class="col-sm col-form-label">Frontside</span></label>
						<div class="col-sm">
						<input type="text" class="form-control" id="frontside" name="frontside">
						</div>
						<label for="backside" class="col-sm col-form-label">Backside</span></label>
						<div class="col-sm">
						<input type="text" class="form-control" id="backside" name="backside">
						</div>
					</div>
					<div class="row">
						<label for="special_req" class="col-sm-2 col-form-label">Special Requirement</span></label>
						<div class="col-sm">
						<textarea class="form-control" id="special_req" name="special_req"></textarea>
						</div>
						
					</div>

					<div class="mt-2">
					<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<button class="nav-link active" id="nav-warna-tab" data-toggle="tab" data-target="#nav-warna" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Warna</button>
						<button class="nav-link" id="nav-proses-tab" data-toggle="tab" data-target="#nav-proses" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Proses</button>
					</div>
					</nav>

					<div class="tab-content" id="nav-tabContent">
						<div class="tab-pane fade show active" id="nav-warna" role="tabpanel" aria-labelledby="nav-warna-tab">

						<div class="row mt-2">
							<div class="col-sm-6">
								<form>
									<div class="form-group row">
										<label for="tinta" class="col-sm-2  col-form-label">Frontside</label>
										<div class="col-sm">
											<select name="tinta" class="form-control" id="tinta">
												<?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
													<option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-primary"><i class="fas fa-solid fa-plus text-light"></i></button>
										</div>
									</div>
									
									</form>
									<div class="row mb-1">
										<label for="tinta" class="col-sm-2">&nbsp</label>
										<div class="col-sm">CYAN</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>										
									</div>
									<div class="row mb-1">
										<label for="tinta" class="col-sm-2">&nbsp</label>
										<div class="col-sm">BLACK</div>	
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>																
									</div>
							</div>
							<div class="col-sm-6">
								<form>
									<div class="form-group row">
										<label for="tinta" class="col-sm-2  col-form-label">Backside</label>
										<div class="col-sm">
											<select name="tinta" class="form-control" id="tinta">
												<?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
													<option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-primary"><i class="fas fa-solid fa-plus text-light"></i></button>
										</div>
									</div>
									
									</form>
									<div class="row mb-1">
										<label for="tinta" class="col-sm-2">&nbsp</label>
										<div class="col-sm">CYAN</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>										
									</div>
									<div class="row">
										<label for="tinta" class="col-sm-2">&nbsp</label>
										<div class="col-sm">BLACK</div>	
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>																
									</div>
							</div>
						</div>

						</div>
						<div class="tab-pane fade" id="nav-proses" role="tabpanel" aria-labelledby="nav-proses-tab">
						<div class="row mt-2">
							<div class="col-sm-4">
								<form>
								<label for="tinta" class="form-label">Proses Manual</label>
										<div class="form-group row">
										<div class="col-sm">
											<select name="tinta" class="form-control" id="tinta">
												<?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
													<option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-primary"><i class="fas fa-solid fa-plus text-light"></i></button>
										</div>
									</div>
									
									</form>
									<div class="row mb-1">
										<div class="col-sm">CYAN</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>										
									</div>
									<div class="row mb-1">
										<div class="col-sm">BLACK</div>	
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>																
									</div>
							</div>
							<div class="col-sm-4">
								<form>
								<label for="tinta" class="form-label">Proses Finishing</label>
										<div class="form-group row">
										<div class="col-sm">
											<select name="tinta" class="form-control" id="tinta">
												<?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
													<option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-primary"><i class="fas fa-solid fa-plus text-light"></i></button>
										</div>
									</div>
									
									</form>
									<div class="row mb-1">
										<div class="col-sm">CYAN</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>										
									</div>
									<div class="row mb-1">
										<div class="col-sm">BLACK</div>	
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>																
									</div>
							</div>
							
							<div class="col-sm-4">
								<form>
								<label for="tinta" class="form-label">Proses Khusus</label>
										<div class="form-group row">
										<div class="col-sm">
											<select name="tinta" class="form-control" id="tinta">
												<?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
													<option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
												<?php endforeach;?>
											</select>
										</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-primary"><i class="fas fa-solid fa-plus text-light"></i></button>
										</div>
									</div>
									
									</form>
									<div class="row mb-1">
										<div class="col-sm">CYAN</div>
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>										
									</div>
									<div class="row mb-1">
										<div class="col-sm">BLACK</div>	
										<div class="col-sm">
											<button type="submit" class="btn-sm btn-danger"><i class="fas fa-trash-alt text-light"></i></button>
										</div>																
									</div>
							</div>
						</div>



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
<div class="modal fade modalForm" id="cariPart" tabindex="-1" aria-labelledby="cariPartLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cariPartLabel">Cari Part Produk</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form name="form-caripartproduk">
  <div class="form-row align-items-center">
    <div class="col-6">
      <label class="sr-only" for="cariproduk">Cari Part Produk</label>
      <input type="text" style="text-transform:uppercase" class="form-control mb-2" name="cariproduk" id="cariproduk" placeholder="Cari Produk Berdasarkan Nomor FGD atau Nama Part Produk">
    </div>
	<div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Cari</button>
    </div>
    <div class="col-auto">
      <a type="button" class="btn btn-primary add-new mb-2" href="mfpartproduk/addPartProduct">Buat Baru</a>
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
			<th>Ukuran</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

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