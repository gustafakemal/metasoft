<?=$this->extend('theme')?>
<?php
//dd($time);
?>
<?=$this->section('title')?>
<?=$page_title;?>
<?=$this->endSection();?>

<?=$this->section('content')?>

<h3 class="page-title"><?=$page_title;?></h3>

<?php if (session()->has('success')): ?>
	<div class="alert alert-success"><?=session()->get('success');?></div>
<?php endif;?>

<form>
<?php
foreach ($data as $x => $v1) {
    ?>
<h5><?=$v1[0];?></h5>

<?php
foreach ($v1[1] as $y => $v2) {
        ?>
<form>
<div class="form-group row">
    <label for="nama" class="col-sm-2 col-form-label"><?=$v2['nama'];?></label>
    <div class="col-sm-21">
      <input type="number" id="nilai-<?=$y;?>" class="form-control" id="nilai" placeholder="Nilai" value="<?=$v2['nilai'];?>" min="0.00" step="0.01">
	  <input type="hidden" id="id-<?=$y;?>" value="<?=$v2['id'];?>">
	</div>
	<div class="col-sm-2">
	<select class="form-control" id="aktif-<?=$y;?>">
	<option value="Y" <?php if ($v2['aktif'] == "Y") {
            echo 'selected';
        }
        ?>>Aktif</option>
	<option value="T" <?php if ($v2['aktif'] == "T") {
            echo 'selected';
        }
        ?>>Tidak Aktif</option>
    </select>
	</div>

	<div class="col-sm-3">
	Update terakhir: <?=$time->dateFormat($v2['updated']);?><br>
	Oleh: <?=$v2['updated_by'];?>
	</div>
	<div class="col">
	<button type="submit" id="<?=$y;?>" class="btn btn-primary btn-sm konstanta-save">Simpan</button>
	</div>
  </div>
  </form>
<?php
}
    ?>

<?php
}

?>




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
								<label for="nama">Aksesori <span class="text-danger">*</span></label>
								<input name="nama" type="text" class="form-control" id="nama">
							</div>
							<div class="form-group">
								<label for="harga">Harga <span class="text-danger">*</span></label>
								<input name="harga" type="number" class="form-control" id="harga" value="0">
							</div>
							<div class="form-group">
								<label for="aktif">Status</label>
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
							<label>Aksesori</label>
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

<?=$this->endSection()?>