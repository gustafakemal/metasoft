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
			<th>ID Sales</th>
			<th>Nama Sales</th>
			<th>NIK</th>
			<th>Status Aktif</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

<!-- <form name="dummyform">
<div class="form-check">
									<input class="form-check-input" checked="checked" type="radio" name="aktif" id="msJenisFluteAktif" value="Y">
									<label class="form-check-label" for="msJenisFluteAktif">Aktif</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="aktif" id="msJenisFluteNonaktif" value="T">
									<label class="form-check-label" for="msJenisFluteNonaktif">Nonaktif</label>
								</div>
<button type="submit" name="submit" class="btn btn-primary">Save</button>
							</form> -->

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="SalesID" value="" />
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
								<label for="nik">NIK <span class="text-danger">*</span></label>
								<input name="NIK" type="number" class="form-control" id="nik">
							</div>
							<div class="form-group">
								<label for="salesName">Nama Sales <span class="text-danger">*</span></label>
								<input name="SalesName" type="text" class="form-control" id="salesName">
							</div>
							<div class="form-group">
								<label for="flagAktif">Status Aktif</label>
								<select name="FlagAktif" class="form-control" id="flagAktif">
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
				<h5 class="modal-title" id="dataDetailLabel">Data Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<div class="item">
							<label>Nama Sales</label>
							<div class="dataDet SalesName"></div>
						</div>
						<div class="item">
							<label>NIK</label>
							<div class="dataDet NIK"></div>
						</div>
						<div class="item">
							<label>Status Aktif</label>
							<div class="dataDet FlagAktif"></div>
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