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


<div class="dynamic-content">


<form name="partproduct-form" class="csc-form show">
	<div class="msg"></div>
	<div class="form-group row">
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
	<div class="form-group row">
		<label for="nama_produk" class="col-sm-2 col-form-label">Nama Part Produk <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="nama_produk" name="nama_produk">
		</div>
	</div>
	<div class="form-group row">
		<label for="tujuan_penggunaan" class="col-sm-2 col-form-label">Tujuan Penggunaan <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="tujuan_penggunaan" name="tujuan_penggunaan">
		</div>
	</div>
	<div class="form-group row">
		<label for="panjang" class="col-sm-2 col-form-label">Ukuran Jadi<span class="text-danger">*</span></label>
		<div class="col-sm-4">
		<input type="number" class="form-control" id="panjang" name="panjang"  placeholder="Panjang">
		</div>
		<div class="col-sm-3">
		<input type="number" class="form-control" id="lebar" name="lebar"  placeholder="Lebar">
		</div>
		<div class="col-sm-3">
		<input type="number" class="form-control" id="tinggi" name="tinggi"  placeholder="Tinggi">
		</div>
	</div>
	<div class="form-group row">
		<label for="kertas" class="col-sm-2 col-form-label">Kertas </label>
		<div class="col-sm-4">
			<select name="kertas" class="form-control" id="kertas">
			<option value="0" selected>Pilih Jenis Kertas</option>
				<?php foreach ($opsi_jeniskertas as $key => $opsi_jeniskertas_item) : ?>
					<option value="<?= $opsi_jeniskertas_item->id;?>"><?= $opsi_jeniskertas_item->nama;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="flute" class="col-sm-2 col-form-label">Flute </label>
		<div class="col-sm-4">
		<select name="flute" class="form-control" id="flute">
			<option value="0" selected>Pilih Jenis Flute</option>
				<?php foreach ($opsi_jenisflute as $key => $opsi_jenisflute_item) : ?>
					<option value="<?= $opsi_jenisflute_item->id;?>"><?= $opsi_jenisflute_item->nama;?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		
		<label for="technical_draw" class="col-sm-2 col-form-label">Technical Draw </label>
		<div class="col-sm-2">
		<select name="technical_draw" id="technical_draw" class="form-control">
					<option value="Y">Ya</option>
					<option value="T" selected>Tidak</option>
				</select>
		</div>
		<label for="no_dokumen" class="col-sm-2 col-form-label">No Dokumen </label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="no_dokumen" name="no_dokumen">
		</div>
	</div>
	<div class="form-group row">
		<label for="inner_pack" class="col-sm-2 col-form-label">Inner Pack </label>
		<div class="col-sm-4">
			<select name="inner_pack" class="form-control" id="inner_pack">
			<option value="0" selected>Pilih Jenis Inner Pack</option>
				<?php foreach ($opsi_innerpack as $key => $opsi_innerpack_item) : ?>
					<option value="<?= $opsi_innerpack_item->id;?>"><?= $opsi_innerpack_item->nama;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="jum_innerpack" class="col-sm-2 col-form-label">Jumlah </label>
		<div class="col-sm-2">
		<input type="number" class="form-control" id="jum_innerpack" name="jum_innerpack"  value="0">
		
		</div>
	</div>
	<div class="form-group row">
		<label for="outer_pack" class="col-sm-2 col-form-label">Outer Pack </label>
		<div class="col-sm-4">
			<select name="outer_pack" class="form-control" id="outer_pack">
			<option value="0" selected>Pilih Jenis Outer Pack</option>
				<?php foreach ($opsi_outerpack as $key => $opsi_outerpack_item) : ?>
					<option value="<?= $opsi_outerpack_item->id;?>"><?= $opsi_outerpack_item->nama;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="jum_outerpack" class="col-sm-2 col-form-label">Jumlah </label>
		<div class="col-sm-2">
		<input type="number" class="form-control" id="jum_outerpack" name="jum_outerpack"  value="0">
		
		</div>
	</div>
	<div class="form-group row">
		<label for="deliver_pack" class="col-sm-2 col-form-label">Delivery Pack </label>
		<div class="col-sm-4">
			<select name="deliver_pack" class="form-control" id="deliver_pack">
			<option value="0" selected>Pilih Jenis Delivery Pack</option>
				<?php foreach ($opsi_deliverypack as $key => $opsi_deliverypack_item) : ?>
					<option value="<?= $opsi_deliverypack_item->id;?>"><?= $opsi_deliverypack_item->nama;?></option>
				<?php endforeach;?>
			</select>
		</div>
		<label for="auto_pack" class="col-sm-4 col-form-label">Auto Packing Machine di Customer </label>
		<div class="col-sm-2">
		<select name="auto_pack" id="auto_pack" class="form-control">
					<option value="Y">Ya</option>
					<option value="T" selected>Tidak</option>
				</select>
		
		</div>
	</div>
	<div class="form-group row">
		<label for="special_req" class="col-sm-2 col-form-label">Special Request </label>
		<div class="col-sm-10">
			<textarea name="special_req" class="form-control" id="special_req"></textarea>

		</div>
	</div>
	<div class="form-group row">
		
		<label for="no_dokcr" class="col-sm-3 col-form-label">Dokumen Change Request </label>
		<div class="col-sm-3">
		<input type="text" class="form-control" id="no_dokcr" name="no_dokcr">
		</div>
		<label for="file_dokcr" class="col-sm-2 col-form-label">Upload Dokumen </label>
		<div class="col-sm-4">
			<input type="file" class="form-control" id="file_dokcr" name="file_dokcr">
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
	<h5>Sisi Part Produk</h5>
    </div>
    <div class="col text-right">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataForm">
  Tambah Sisi
</button>
    </div>
  </div>
 
</div>
<div class="tbl-data-sisipartproduct">
<table id="dataList" class="table table-bordered table-striped" style="width: 100%;">
	
	<thead>
		<tr>
			<th>Sisi</th>
			<th>Warna<br>Frontside</th>
			<th>Warna<br>Backside</th>
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

<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
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
											<button type="submit" class="btn-sm btn-primary">+</button>
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
											<button type="submit" class="btn-sm btn-primary">+</button>
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
											<button type="submit" class="btn-sm btn-primary">+</button>
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
											<button type="submit" class="btn-sm btn-primary">+</button>
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
											<button type="submit" class="btn-sm btn-primary">+</button>
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