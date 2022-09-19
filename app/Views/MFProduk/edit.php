<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
    <div class="hidden-success-el d-none"><?= session()->get('success'); ?></div>
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
  </div>
</form>

<div class="dynamic-content">


<form name="csc-form" class="csc-form show edit-produk-form">
	<div class="msg"></div>
    <input type="hidden" name="id" value="" />
	<div class="form-group row">
		<label for="nama_produk" class="col-sm-2 col-form-label">Nama Produk <span class="text-danger">*</span></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $data->nama_produk;?>" style="text-transform: uppercase">
		</div>
	</div>
	<div class="form-group row">
		<label for="segmen" class="col-sm-2 col-form-label">Segmen <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="segmen" class="form-control" id="segmen">
                <option value="">-Pilih segmen-</option>
                <option selected value="<?= $data->OpsiVal;?>"><?= $data->OpsiTeks;?></option>
			</select>
		</div>
		<label for="sales" class="col-sm-2 col-form-label">Sales <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="sales" class="form-control" id="sales">
                <option value="">-Pilih sales-</option>
                <option selected value="<?= $data->SalesID;?>"><?= $data->SalesName;?></option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="customer" class="col-sm-2 col-form-label">Pelanggan <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="customer" class="form-control" id="customer">
                <option value="">-Pilih pelanggan-</option>
                <option selected value="<?= $data->NoPemesan;?>"><?= $data->NamaPemesan;?></option>
			</select>
		</div>
		<label for="contact_person" class="col-sm-2 col-form-label">Contact Person <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="contact_person" name="contact_person" value="<?= $data->contact_person;?>">
		</div>
	</div>
	<div class="form-group row">
		<label for="tujuan_kirim" class="col-sm-2 col-form-label">Tujuan Kirim <span class="text-danger">*</span></label>
		<div class="col-sm-4">
			<select name="tujuan_kirim" class="form-control" id="tujuan_kirim">
                <option value="">-Pilih tujuan-</option>
                <option selected value="<?= $data->tujuan_id;?>"><?= $data->tujuan;?></option>
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
	<button type="button" class="btn btn-success open-search" data-id="<?= $data->id;?>">
	<i class="fas fa-solid fa-search text-light"></i>&nbsp;Cari
</button>
	<a href="<?= site_url('partproduk/add?ref=y&id_produk=' . $data->id);?>" type="button" class="btn btn-success"><i class="fa fa-plus-circle text-light"></i>&nbsp;Tambah</a>
    </div>
  </div>
 
</div>
<div class="tbl-data-partproduct">
<table id="dataPartProduk" class="table table-bordered table-striped" style="width: 100%;">
	
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
      <label class="sr-only" for="caripartproduk">Cari Part Produk</label>
      <input type="text" style="text-transform:uppercase" class="form-control mb-2" name="caripartproduk" id="caripartproduk" placeholder="Cari Produk Berdasarkan Nomor FGD atau Nama Part Produk">
    </div>
	<div class="col-auto">
      <button type="submit" class="btn btn-primary mb-2">Cari</button>
    </div>
  </div>
</form>

<div class="dynamic-content">

<div class="tbl-data-partproduct">

<table id="dataPartHasilCari" class="table table-bordered table-striped" style="width: 100%;">
	
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

    <!-- Modal -->
    <div class="modal fade" id="dataDetail" tabindex="-1" aria-labelledby=dataDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="sisi-form-modal">
                <input type="hidden" name="id" value="" />
                <div class="modal-content sisi-produk">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataDetailLabel"><span class="heading-sisi-produk">Sisi Part Produk</span><span class="part-produk-title"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="row">
                            <label for="fgd" class="col-sm-2 col-form-label">No FGD</span></label>
                            <div class="col-sm-4">
                                <div class="sisi-view fgd"></div>
                            </div>
                            <label for="trevisi" class="col-sm-2 col-form-label">Revisi</span></label>
                            <div class="col-sm-4">
                                <div class="sisi-view revisi"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="sisi" class="col-sm-2 col-form-label">Sisi</span></label>
                            <div class="col-sm">
                                <div class="sisi-view sisi"></div>
                            </div>
                            <label for="frontside" class="col-sm col-form-label">Frontside</span></label>
                            <div class="col-sm">
                                <div class="sisi-view frontside"></div>
                            </div>
                            <label for="backside" class="col-sm col-form-label">Backside</span></label>
                            <div class="col-sm">
                                <div class="sisi-view backside"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="special_req" class="col-sm-2 col-form-label">Special Requirement</span></label>
                            <div class="col-sm">
                                <div class="sisi-view special_req"></div>
                            </div>

                        </div>
                        <div class="row">
                            <label for="special_req" class="col-sm-2 col-form-label">Aktif</label>
                            <div class="col-sm">
                                <div class="sisi-view aktif"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="fgd" class="col-sm-2 col-form-label">Ditambahkan pada</span></label>
                            <div class="col-sm-4">
                                <div class="sisi-view added"></div>
                            </div>
                            <label class="col-sm-2 col-form-label">Oleh</span></label>
                            <div class="col-sm-4">
                                <div class="sisi-view added_by"></div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <nav>
                                <div class="nav nav-tabs" id="det_nav-tab" role="tablist">
                                    <button class="nav-link active" id="det_nav-warna-tab" data-toggle="tab" data-target="#det_nav-warna" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Warna</button>
                                    <button class="nav-link" id="det_nav-proses-tab" data-toggle="tab" data-target="#det_nav-proses" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Proses</button>
                                </div>
                            </nav>

                            <div class="tab-content" id="det_nav-tabContent">
                                <div class="tab-pane fade show active" id="det_nav-warna" role="tabpanel" aria-labelledby="det_nav-warna-tab">

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="tinta" class="col-sm-2  col-form-label">Frontside</label>
                                            </div>
                                            <div class="fs-child"></div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="tinta" class="col-sm-2  col-form-label">Backside</label>
                                            </div>
                                            <div class="bs-child"></div>

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="det_nav-proses" role="tabpanel" aria-labelledby="det_nav-proses-tab">
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <label for="tinta" class="form-label">Proses Manual</label>
                                            <div class="manual-child"></div>

                                        </div>
                                        <div class="col-sm-4">
                                            <label for="tinta" class="form-label">Proses Finishing</label>
                                            <div class="finishing-child"></div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="tinta" class="form-label">Proses Khusus</label>
                                            <div class="khusus-child"></div>

                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="loading-indicator"></div>
                        <div class="form-navigation">
                            <button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?= $this->endSection() ?>