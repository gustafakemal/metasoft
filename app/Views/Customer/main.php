<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<h3 class="page-title"><?= $page_title;?></h3>

<?php if(session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success');?></div>
<?php endif;?>

		<table id="customerList" class="table table-bordered table-striped" style="width: 100%">
			<thead>
				<tr>
					<th style="width: 25px;">No</th>
					<th>Tanggal dibuat</th>
					<th>Nama Pemesan</th>
					<th>Contact person</th>
					<th>Wajib pajak</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
		</table>

<!-- Modal -->
<div class="modal fade" id="customerForm" tabindex="-1" aria-labelledby="customerFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="NoPemesan" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="customerFormLabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col-6">
							<div class="form-group">
								<label for="namaPemesan">Nama pemesan</label>
								<input name="NamaPemesan" type="text" class="form-control" id="namaPemesan">
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
								<label for="wajibPajak">Wajib pajak</label>
								<input name="WajibPajak" type="text" class="form-control" id="wajibPajak">
							</div>
							<div class="form-group">
								<label for="npwp">NPWP</label>
								<input name="NPWP" type="text" class="form-control" id="npwp">
							</div>
							<div class="form-group">
								<label for="alamatPengiriman1">Alamat pengiriman 1</label>
								<textarea name="AlamatPengiriman1" rows="3" class="form-control" id="alamatPengiriman1"></textarea>
							</div>
							<div class="form-group">
								<label for="alamatPengiriman2">Alamat pengiriman 2</label>
								<textarea name="AlamatPengiriman2" rows="3" class="form-control" id="alamatPengiriman2"></textarea>
							</div>
							<div class="form-group">
								<label for="alamatPenagihan">Alamat penagihan</label>
								<textarea name="AlamatPenagihan" rows="3" class="form-control" id="alamatPenagihan"></textarea>
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
<div class="modal fade" id="customerDetail" tabindex="-1" aria-labelledby="customerDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="customerDetailLabel">Customer detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped mb-0">
					<tbody>
						<tr>
							<td class="text-right" style="width: 45%">Nama pemesan</td>
							<td class="custDet NamaPemesan"></td>
						</tr>
						<tr>
							<td class="text-right">Alamat</td>
							<td class="custDet Alamat"></td>
						</tr>
						<tr>
							<td class="text-right">No Telp</td>
							<td class="custDet NoTelp"></td>
						</tr>
						<tr>
							<td class="text-right">No Fax</td>
							<td class="custDet NoFax"></td>
						</tr>
						<tr>
							<td class="text-right">Contact person 1</td>
							<td class="custDet ContactPerson1"></td>
						</tr>
						<tr>
							<td class="text-right">Contact person 2</td>
							<td class="custDet ContactPerson2"></td>
						</tr>
						<tr>
							<td class="text-right">Wajib pajak</td>
							<td class="custDet WajibPajak"></td>
						</tr>
						<tr>
							<td class="text-right">NPWP</td>
							<td class="custDet NPWP"></td>
						</tr>
						<tr>
							<td class="text-right">Alamat pengiriman 1</td>
							<td class="custDet AlamatPengiriman1"></td>
						</tr>
						<tr>
							<td class="text-right">Alamat pengiriman 2</td>
							<td class="custDet AlamatPengiriman2"></td>
						</tr>
						<tr>
							<td class="text-right">Alamat penagihan</td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">Flag aktif</td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">Dibuat oleh</td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">Dibuat pada</td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">Diupdate oleh</td>
							<td></td>
						</tr>
						<tr>
							<td class="text-right">Update terakhir</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection()?>