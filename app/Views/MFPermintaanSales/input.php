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

<?php
//echo dd($data_produk);
?>
	<div class="msg"></div>
	
	<div class="form-group row">
		<label for="fgd" class="col-sm-2 col-form-label">No FGD</span></label>
		<div class="col-sm-4">
		<input type="text" class="form-control" id="fgd" name="fgd" value="<?= $data_produk[0]->fgd;?>" >
		</div>
		<label for="trevisi" class="col-sm-2 col-form-label">Revisi</span></label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="revisi" name="revisi" value="<?= $data_produk[0]->revisi;?>" >
		</div>
	</div>
	<div class="form-group row">
		<label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $data_produk[0]->nama_produk;?>" >
		</div>
	</div>
	<div class="form-group row">
		<label for="segmen" class="col-sm-2 col-form-label">Segmen</label>
		<div class="col-sm-4">
		<input type="text" class="form-control" id="segmen" name="segmen" value="<?= $data_produk[0]->segmen;?>" >
		</div>
		<label for="sales" class="col-sm-2 col-form-label">Sales</label>
		<div class="col-sm-4">
		<input type="text" class="form-control" id="sales" name="sales" value="<?= $data_produk[0]->sales;?>" >
		</div>
	</div>
	<div class="form-group row">
		<label for="customer" class="col-sm-2 col-form-label">Pelanggan </label>
		<div class="col-sm-4">
		<input type="text" class="form-control" id="customer" name="customer" value="<?= $data_produk[0]->pemesan;?>" >
		</div>
		<label for="contact_person" class="col-sm-2 col-form-label">Contact Person </label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="contact_person" name="contact_person" value="<?= $data_produk[0]->contact_person;?>" >
		</div>
	</div>
	<div class="form-group row">
		<label for="tujuan_kirim" class="col-sm-2 col-form-label">Tujuan Kirim</label>
		<div class="col-sm-4">
		<input type="text" class="form-control" id="tujuan_kirim" name="tujuan_kirim" value="<?= $data_produk[0]->tujuan_kirim;?>" >
		</div>
	</div>
	<div class="form-group row">
		<label for="tujuan_penggunaan" class="col-sm-2 col-form-label">Tujuan Penggunaan</label>
		<div class="col-sm-4">
			<textarea name="tujuan_penggunaan" class="form-control" id="tujuan_penggunaan" row="3" ><?= $data_produk[0]->tujuan_penggunaan;?></textarea>
		</div>
		<label for="special_req" class="col-sm-2 col-form-label">Kebutuhan Khusus</label>
		<div class="col-sm-4">
			<textarea name="special_req" class="form-control" id="special_req" row="3" ><?= $data_produk[0]->special_req;?></textarea>
		</div>
	</div>
	<div class="form-group row row-change-request">
		<label for="no_dokcr" class="col-sm-3 col-form-label">No Dokumen Change Request</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="no_dokumen" name="no_dokumen" value="<?= $data_produk[0]->no_dokcr;?>">
		</div>
		<label class="col-sm-2  col-form-label" for="file_dokcr">File Dokumen</label>
		<div class=" col-sm-4">
			<input type="text" class="form-control" id="file_dokcr" name="file_dokcr" value="<?= $data_produk[0]->file_dokcr;?>">
			
		</div>
	</div>
	<div class="form-group row">
		<label for="frontside" class="col-sm-2 col-form-label">Warna Frontside</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="frontside" name="frontside" value="<?= $data_produk[0]->frontside;?>">
		</div>
		<label for="backside" class="col-sm-2 col-form-label">Warna Backside</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="backside" name="backside" value="<?= $data_produk[0]->backside;?>">
		</div>
	</div>
	<ul class="nav nav-tabs" id="myTab" role="tablist">
  		<li class="nav-item">
    		<a class="nav-link active" id="layout-tab" data-toggle="tab" href="#layout" role="tab" aria-controls="layout" aria-selected="true">Layout/Dimensi</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="material-tab" data-toggle="tab" href="#material" role="tab" aria-controls="material" aria-selected="false">Material</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="packing-tab" data-toggle="tab" href="#packing" role="tab" aria-controls="packing" aria-selected="false">Packing</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="warna-tab" data-toggle="tab" href="#warna" role="tab" aria-controls="warna" aria-selected="false">Warna</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" id="proses-tab" data-toggle="tab" href="#proses" role="tab" aria-controls="proses" aria-selected="false">Proses</a>
  		</li>
	</ul>
	<div class="tab-content" id="myTabContent">
  		<div class="tab-pane fade show active" id="layout" role="tabpanel" aria-labelledby="layout-tab">
  			<div class="mt-4">
 	 			<div class="form-group row">
				  	<label for="technical_draw" class="col-sm-2 col-form-label">Technical Drawing</label>
					<div class="col-sm-4">
					<input type="text" class="form-control" id="technical_draw" name="technical_draw" value="<?= ($data_produk[0]->technical_draw=='Y')?'Ya':'Tidak';?>">
						
					</div>
					<label for="no_dokumen" class="col-sm-2 col-form-label">No Dokumen</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="no_dokumen" name="no_dokumen"  value="<?= $data_produk[0]->no_dokumen;?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="ukuranjadi" class="col-sm-2 col-form-label">Ukuran Jadi (mm)</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="panjang" name="panjang"  value="<?= $data_produk[0]->panjang;?>">
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="lebar" name="lebar"  value="<?= $data_produk[0]->lebar;?>">
					</div>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="tinggi" name="tinggi"   value="<?= $data_produk[0]->tinggi;?>">
					</div>
				</div>
			</div>	
  		</div>
  		<div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="material-tab">
			<div class="mt-4">
				<div class="form-group row">
					<label for="kertas" class="col-sm-2 col-form-label">Kertas</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="kertas" name="kertas"   value="<?= $data_produk[0]->nama_kertas;?>">
					</div>
					<label for="flute" class="col-sm-1 col-form-label">Flute</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="flute" name="flute"   value="<?= $data_produk[0]->nama_flute;?>">
					</div>
					<label for="metalize" class="col-sm-1 col-form-label">Metalize</label>
					<div class="col-sm-2">
					<input type="text" class="form-control" id="metalize" name="metalize"   value="<?= $data_produk[0]->metalize=='Y'?'Ya':'Tidak';?>">
					
					</div>
				</div>
			</div>
  		</div>
		<div class="tab-pane fade" id="packing" role="tabpanel" aria-labelledby="packing-tab">
			<div class="mt-4">
				<div class="form-group row">
					<label for="inner_pack" class="col-sm-2 col-form-label">Inner Pack</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="inner_pack" name="inner_pack"   value="<?= $data_produk[0]->nama_innerpack;?>">

					</div>
					<label for="jum_innerpack" class="col-sm-3 col-form-label">Jumlah per Pack</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="jum_innerpack" name="jum_innerpack"  value="<?= $data_produk[0]->jum_innerpack;?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="outer_pack" class="col-sm-2 col-form-label">Outer Pack</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="outer_pack" name="outer_pack"   value="<?= $data_produk[0]->nama_outerpack;?>">

					</div>
					<label for="jum_outerpack" class="col-sm-3 col-form-label">Jumlah per Pack</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="jum_outerpack" name="jum_outerpack"   value="<?= $data_produk[0]->jum_outerpack;?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="deliver_pack" class="col-sm-2 col-form-label">Deliver Pack</label>
					<div class="col-sm-3">
					<input type="text" class="form-control" id="deliver_pack" name="deliver_pack"   value="<?= $data_produk[0]->nama_deliverpack;?>">

					</div>
					<label for="auto_pack" class="col-sm-3 col-form-label">Auto Packing Machine di Customer</label>
					<div class="col-sm-2">
					<input type="text" class="form-control" id="auto_pack" name="auto_pack"   value="<?= $data_produk[0]->auto_pack=='Y'?'Ya':'Tidak';?>">
					
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade color-tab" id="warna" role="tabpanel" aria-labelledby="warna-tab">
			<div class="mt-4">
				<div class="row">
					<div class="col-sm">
						<div class="row">
							<label for="warnafrontside" class="col-sm col-form-label">Warna Frontside</label>
							
						</div>
						<div class="row">
									<?php foreach ($data_frontside as $key => $warna_frontside) : ?>
										<div class="col-sm-12">
										<?= $warna_frontside->nama_tinta;?>
										</div>
									<?php endforeach;?>
							
						</div>
						
						
					</div>
					
					<div class="col-sm">
					<div class="row">
						<label for="warnabackside" class="col-sm col-form-label">Warna Backside</label>
							
						</div>
						<div class="row">
									<?php foreach ($data_backside as $key => $warna_backside) : ?>
										<div class="col-sm-12">
										<?= $warna_backside->nama_tinta;?>
										</div>
									<?php endforeach;?>
							
						</div>
						
						
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane fade" id="proses" role="tabpanel" aria-labelledby="proses-tab">
		<div class="mt-4">
				<div class="row">
					<div class="col-sm">
						<div class="row">
							<label for="finishing" class="col-sm col-form-label">Finishing</label>
							
						</div>
						<div class="row">
							<div class="col-sm-9">
								<select class="form-control" id="finishing">
									<option value="" selected>--Pilih Finishing--</option>
									<?php foreach ($opsi_finishing as $key => $opsifinishing_item) : ?>
										<option value="<?= $opsifinishing_item->id;?>"><?= $opsifinishing_item->proses;?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-primary btn-sm" id="finishing-btn"><i class="fas fa-plus"></i></button>
							</div>
						</div>
						<div class="finishing-selected"></div>
					</div>
					<div class="col-sm">
						<div class="row">
							<label for="manual" class="col-sm col-form-label">Manual</label>
							
						</div>
						<div class="row">
							<div class="col-sm-9">
								<select class="form-control" id="manual">
									<option value="" selected>--Pilih Manual--</option>
									<?php foreach ($opsi_manual as $key => $opsimanual_item) : ?>
										<option value="<?= $opsimanual_item->id;?>"><?= $opsimanual_item->proses;?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-primary btn-sm" id="manual-btn"><i class="fas fa-plus"></i></button>
							</div>
						</div>
						<div class="manual-selected"></div>

					</div>
					<div class="col-sm">
					<div class="row">
						<label for="khusus" class="col-sm col-form-label">Khusus</label>
							
						</div>
						<div class="row">
							<div class="col-sm-9">
								<select class="form-control" id="khusus">
									<option value="" selected>--Pilih Khusus--</option>
									<?php foreach ($opsi_khusus as $key => $opsikhusus_item) : ?>
										<option value="<?= $opsikhusus_item->id;?>"><?= $opsikhusus_item->proses;?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="col-sm-3">
								<button type="button" class="btn btn-primary btn-sm" id="khusus-btn"><i class="fas fa-plus"></i></button>
							</div>
						</div>
						<div class="khusus-selected"></div>
						
					</div>
				</div>
			</div>
		</div>
</div>


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