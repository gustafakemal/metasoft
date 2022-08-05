<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<table id="dataList" class="table table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
			<th style="width: 25px;">No</th>
			<th>No Pemesan</th>
			<th>Tanggal dibuat</th>
			<th>Nama Pemesan</th>
			<th>Alamat</th>
			<th>No Fax</th>
			<th>No Telp</th>
			<th>Contact person</th>
			<th>Contact person 2</th>
			<th>Wajib pajak</th>
			<th>NPWP</th>
			<th>Alamat pengiriman 1</th>
			<th>Alamat pengiriman 2</th>
			<th>Alamat penagihan</th>
			<th>Status aktif</th>
			<th>Dibuat oleh</th>
			<th>Diupdate oleh</th>
			<th>Update terakhir</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="NoPemesan" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="namaPemesan">Nama pemesan <span class="text-danger">*</span></label>
								<input name="NamaPemesan" type="text" class="form-control" id="namaPemesan">
							</div>
							<div class="form-group">
								<label for="InternEkstern">Tipe</label>
								<select class="form-control" id="internEkstern" name="InternEkstern" value="E">
									<option value="E">Eksternal</option>
									<option value="I">Internal</option>
								</select>
							
								
							</div>
							<div class="form-group">
								<label for="alamat">Alamat</label>
								<textarea name="Alamat" rows="4" class="form-control" id="alamat"></textarea>
							</div>
							<div class="form-group">
								<label for="noTelp">No Telp</label>
								<input name="NoTelp" type="text" class="form-control" id="noTelp">
							</div>
							<div class="form-group">
								<label for="noFax">No Fax</label>
								<input name="NoFax" type="text" class="form-control" id="noFax">
							</div>
							<div class="form-group">
								<label for="contactPerson1">Contact person 1</label>
								<input name="ContactPerson1" type="text" class="form-control" id="contactPerson1">
							</div>
							<div class="form-group">
								<label for="contactPerson2">Contact person 2</label>
								<input name="ContactPerson2" type="text" class="form-control" id="contactPerson2">
							</div>

						</div>
						<div class="col-6">
							<div class="form-group">
								<label class="d-block">Wajib pajak</label>
								<select class="form-control" name="WajibPajak" id="wajibPajak" value="Y">
									<option value="Y">Ya</option>
									<option value="T">Tidak</option>
								</select>	
								
							</div>
							<div class="form-group">
								<label for="npwp">NPWP</label>
								<input name="NPWP" type="text" class="form-control" id="npwp">
							</div>
							<div class="form-group">
								<label for="alamatPengiriman1">Alamat pengiriman</label>
								<textarea name="AlamatPengiriman1" rows="3" class="form-control mb-1" id="alamatPengiriman1" maxlength="255"></textarea>
								<textarea name="AlamatPengiriman2" rows="3" class="form-control" id="alamatPengiriman2" maxlength="255"></textarea>
							</div>
							<div class="form-group">
								<label for="alamatPenagihan">Alamat penagihan</label>
								<textarea name="AlamatPenagihan" rows="3" class="form-control" id="alamatPenagihan"></textarea>
							</div>
							<div class="form-group">
								<label>Status aktif</label>
								<select class="form-control" name="FlagAktif" id="flagAktif" value="A">
									<option value="A">Ya</option>
									<option value="N">Tidak</option>
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
				<h5 class="modal-title" id="dataDetailLabel">Data detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
						<div class="item">
							<label>Nama pemesan</label>
							<div class="custDet NamaPemesan"></div>
						</div>
						<div class="item">
							<label>Tipe</label>
							<div class="custDet InternEkstern"></div>
						</div>
						<div class="item">
							<label>Alamat</label>
							<div class="custDet Alamat"></div>
						</div>
						<div class="item">
							<label>No Fax</label>
							<div class="custDet NoFax"></div>
						</div>
						<div class="item">
							<label>No Telp</label>
							<div class="custDet NoTelp"></div>
						</div>
						<div class="item">
							<label>Contact person 1</label>
							<div class="custDet ContactPerson1"></div>
						</div>
						<div class="item">
							<label>Contact person 2</label>
							<div class="custDet ContactPerson2"></div>
						</div>
						
						<div class="item">
							<label>Alamat Pengiriman 1</label>
							<div class="custDet AlamatPengiriman1"></div>
						</div>
						<div class="item">
							<label>Alamat Pengiriman 2</label>
							<div class="custDet AlamatPengiriman2"></div>
						</div>
						
					</div>
					<div class="col-6">
						<div class="item">
							<label>Alamat penagihan</label>
							<div class="custDet AlamatPenagihan"></div>
						</div>
						<div class="item">
							<label>Wajib pajak</label>
							<div class="custDet WajibPajak"></div>
						</div>
						<div class="item">
							<label>NPWP</label>
							<div class="custDet NPWP"></div>
						</div>
						<div class="item">
							<label>Status aktif</label>
							<div class="custDet FlagAktif"></div>
						</div>
						<div class="item">
							<label>Dibuat pada</label>
							<div class="custDet CreateDate"></div>
						</div>
						<div class="item">
							<label>Dibuat oleh</label>
							<div class="custDet CreateBy"></div>
						</div>
						<div class="item">
							<label>Diupdate pada</label>
							<div class="custDet LastUpdate"></div>
						</div>
						<div class="item">
							<label>Diupdate oleh</label>
							<div class="custDet UpdateBy"></div>
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