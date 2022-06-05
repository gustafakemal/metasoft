<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<div class="page-title-wrapper">
    <h3 class="page-title"><?= $page_title;?></h3>
</div>

<div class="row">
	<div class="col-lg-12 col-sm-12">
		
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

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="customerForm" tabindex="-1" aria-labelledby="customerFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form name="addCustomer">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="customerFormLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="namaPemesan" class="col-sm-4 col-form-label">Nama pemesan</label>
						<div class="col-sm-8">
							<input name="NamaPemesan" type="text" class="form-control" id="namaPemesan">
						</div>
					</div>
					<div class="form-group row">
						<label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
						<div class="col-sm-8">
							<input name="Alamat" type="text" class="form-control" id="alamat">
						</div>
					</div>
					<div class="form-group row">
						<label for="noTelp" class="col-sm-4 col-form-label">No Telp</label>
						<div class="col-sm-8">
							<input name="NoTelp" type="text" class="form-control" id="noTelp">
						</div>
					</div>
					<div class="form-group row">
						<label for="noFax" class="col-sm-4 col-form-label">No Fax</label>
						<div class="col-sm-8">
							<input name="NoFax" type="text" class="form-control" id="noFax">
						</div>
					</div>
					<div class="form-group row">
						<label for="contactPerson1" class="col-sm-4 col-form-label">Contact person 1</label>
						<div class="col-sm-8">
							<input name="ContactPerson1" type="text" class="form-control" id="contactPerson1">
						</div>
					</div>
					<div class="form-group row">
						<label for="contactPerson2" class="col-sm-4 col-form-label">Contact person 2</label>
						<div class="col-sm-8">
							<input name="ContactPerson2" type="text" class="form-control" id="contactPerson2">
						</div>
					</div>
					<div class="form-group row">
						<label for="wajibPajak" class="col-sm-4 col-form-label">Wajib pajak</label>
						<div class="col-sm-8">
							<input name="WajibPajak" type="text" class="form-control" id="wajibPajak">
						</div>
					</div>
					<div class="form-group row">
						<label for="npwp" class="col-sm-4 col-form-label">NPWP</label>
						<div class="col-sm-8">
							<input name="NPWP" type="text" class="form-control" id="npwp">
						</div>
					</div>
					<div class="form-group row">
						<label for="alamatPengiriman1" class="col-sm-4 col-form-label">Alamat pengiriman 1</label>
						<div class="col-sm-8">
							<input name="AlamatPengiriman1" type="text" class="form-control" id="alamatPengiriman1">
						</div>
					</div>
					<div class="form-group row">
						<label for="alamatPengiriman2" class="col-sm-4 col-form-label">Alamat pengiriman 2</label>
						<div class="col-sm-8">
							<input name="AlamatPengiriman2" type="text" class="form-control" id="alamatPengiriman2">
						</div>
					</div>
					<div class="form-group row">
						<label for="alamatPenagihan" class="col-sm-4 col-form-label">Alamat penagihan</label>
						<div class="col-sm-8">
							<input name="AlamatPenagihan" type="text" class="form-control" id="alamatPenagihan">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="loading-indicator"></div>
					<div class="form-navigation">
						<button name="submit" type="submit" class="btn btn-primary">Simpan</button>
						<button name="cancel" type="button" class="btn btn-link text-danger" data-dismiss="modal">Batal</button>
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