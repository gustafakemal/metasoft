<?=$this->extend('theme')?>

<?=$this->section('title')?>
<?=$page_title;?>
<?=$this->endSection();?>

<?=$this->section('content')?>

<h3 class="page-title"><?=$page_title;?></h3>

<?php if (session()->has('success')): ?>
	<div class="alert alert-success"><?=session()->get('success');?></div>
<?php endif;?>

<table id="dataList" class="table table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
			<th style="width: 25px;">No</th>
			<th>Nama</th>
			<th style="width: 100px;">Status Aktif</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
</table>

<!-- Modal -->
<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form>
			<input type="hidden" name="ID" value="" />
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
						<div class="col">
							<div class="form-group">
								<label for="Nama">Segmen<span class="text-danger">*</span></label>
								<input name="Nama" type="text" class="form-control" id="Nama" style="text-transform:uppercase;">
							</div>
							<div class="form-group">
								<label for="Aktif">Status</label>
								<select name="Aktif" class="form-control" id="Aktif">
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
							<label>Segmen</label>
							<div class="dataDet Nama"></div>
						</div>
						<div class="item">
							<label>Status</label>
							<div class="dataDet Aktif"></div>
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

<?=$this->endSection()?>