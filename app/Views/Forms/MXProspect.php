<? // Form Input Prospek Metaflex ?>

<?=$this->extend('theme')?>

<?=$this->section('title')?>
<?=$page_title;?>
<?=$this->endSection();?>

<?=$this->section('content')?>

<h3 class="page-title"><?=$page_title;?></h3>

<?php if (session()->has('success')): ?>
	<div class="alert alert-success"><?=session()->get('success');?></div>
<?php endif;?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?=session()->get('error');?></div>
<?php endif;?>

<?php echo form_open('mxprospect/addProcess');?>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="no_prospek" class="col-lg-4 col-sm-12 col-form-label">No Prospek</label>
                <div class="col-lg-8 col-sm-12">
                    <input type="text" class="form-control" id="no_prospek" name="no_prospek" readonly>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="alt" class="col-lg-4 col-sm-12 col-form-label">Alternatif</label>
                <div class="col-lg-2 col-sm-12">        
                    <input type="number" class="form-control" id="alt" name="alt" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="nama_produk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" style="text-transform: uppercase">
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="pemesan" class="col-lg-4 col-sm-12 col-form-label">Pemesan</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="pemesan" name="pemesan" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($customers as $key => $customer) : ?>
                            <option value="<?= $customer->NoPemesan;?>"><?= $customer->NamaPemesan;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>    
        <div class="col-6">
            <div class="form-group row">
                <label for="jenis_produk" class="col-lg-4 col-sm-12 col-form-label">Jenis Produk</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="jenis_produk" name="jenis_produk" class="form-control">
                        <option value="">Pilih</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="segmen" class="col-lg-4 col-sm-12 col-form-label">Segmen</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="segmen" name="segmen" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="konten" name="konten" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <input type="number" class="form-control" id="tebal" name="tebal" placeholder="Tebal">
        </div>
		<div class="col-sm-2">
            <input type="number" class="form-control" id="panjang" name="panjang" placeholder="Panjang">
        </div>
        <div class="col-sm-2">
            <input type="number" class="form-control" id="lebar" name="lebar" placeholder="Lebar">
        </div>
        <div class="col-sm-2">
            <input type="number" class="form-control" id="pitch" name="pitch" placeholder="Pitch">
        </div>
    </div>

	<div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Material<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <select id="material1" name="material1" class="form-control">
                <option value="">Pilih</option>

            </select>
			<input type="number" class="form-control" id="tebal_material1" name="tebal_material1" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material2" name="material2" class="form-control">
                <option value="">Pilih</option>

            </select>
			<input type="number" class="form-control" id="tebal_material2" name="tebal_material2" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material3" name="material3" class="form-control">
                <option value="">Pilih</option>

            </select>
			<input type="number" class="form-control" id="tebal_material3" name="tebal_material3" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material4" name="material4" class="form-control">
                <option value="">Pilih</option>

            </select>
			<input type="number" class="form-control" id="tebal_material4" name="tebal_material4" placeholder="Tebal">
        </div>
    </div>
				
    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna</label>
                <div class="col-lg-6 col-sm-12">
                    <input type="number" class="form-control" id="warna" name="warna" placeholder="Jumlah Warna">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
                <div class="col-lg-7 col-sm-12">
                    <select id="eyemark" name="eyemark" class="form-control">
                        <option value="1">Eyemark Only</option>
                        <option value="2">Eyemark & Block Color</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="roll_direction" class="col-lg-4 col-sm-12 col-form-label">Roll Direction</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="roll_direction" name="roll_direction" id="roll_direction" class="form-control">
                        <option value="Y">Terbaca</option>
                        <option value="T">Tidak Terbaca</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

	<div class="form-group row">
        <label for="info_tambahan" class="col-lg-2 col-sm-12 col-form-label">Informasi Tambahan</label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="info_tambahan" name="info_tambahan">
        </div>
    </div>

	<div class="form-group row">
        <label for="nama_produk" class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong> </label>
    </div>
            
    <div class="row">
        <div class="col-6">
            <div class="row">
                <label for="max_join" class="col-lg-4 col-sm-12 col-form-label">Maksimal Join </label>
                <div class="col-lg-8 col-sm-12">
                    <input type="number" class="form-control" id="max_join" name="max_join">
                </div>
            </div>
        </div>
		<div class="col-6">
            <div class="form-group row">
                <label for="warna_tape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="warna_tape" name="warna_tape" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="bag_making" class="col-lg-4 col-sm-12 col-form-label">Bag Making</label>
                <div class="col-lg-8 col-sm-12">
                    <select  id="bag_making" name="bag_making" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="bottom" class="col-lg-4 col-sm-12 col-form-label">Bottom</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="bottom" name="bottom" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
    </div>
            
    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="filling" class="col-lg-4 col-sm-12 col-form-label">Open For Filling</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="filling" name="filling" class="form-control">
                        <option value="">Pilih</option>
						<option value="T">Top</option>
						<option value="B">Bottom</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="aksesoris" class="col-lg-4 col-sm-12 col-form-label">Aksesoris</label>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm">
                            <select  id="aksesoris" name="aksesoris" class="form-control">
                                <option value="">Pilih</option>

                            </select>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-sm btn-primary add-bs">+</button>
                        </div>
                    </div>
                    
                    <div class="bs-child">
                        <!-- finishing yg sdh dipilih -->
                        <div class="row mb-1 bscolor-2">
						    <div class="col-sm col-form-label">ZIPPER</div>
						    <div class="col-sm-auto">
							    <button type="button" class="btn-sm btn-danger delbs" id="delbs-2">
							    <i class="fas fa-trash-alt text-light"></i></button>
						    </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Jumlah Order </strong> </label>
    </div>

	<Div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jumlah" class="col-6">Jumlah </label>
                <div class="col-6">
                    <input id="jumlah" name="jumlah" type="number" class="form-control">
				</div>
            </div>
        </div>
		<div class="col-2">
            <div class="form-group row pr-5">
                <select id="roll_pc" name="roll_pc" class="form-control">
                    <option value="R">ROLL</option>
					<option value="P">PCS</option>
                </select>
				<select id="finishing" name="finishing" class="form-control" disabled>
                    <option value="CS">CS</option>
					<option value="CSG">CS GUSET</option>
                    <option value="4SS">4SS</option>
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="toleransi" class="col-lg-7 col-sm-12 col-form-label">Toleransi (%)</label>
                <div class="col-lg-5 col-sm-12">
                    <input id="toleransi" name="toleransi" type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="partial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
                <div class="col-lg-6 col-sm-12">
                    <select id="partial" name="partial" class="form-control">
                        <option value="T">Tidak</option>
						<option value="Y">Ya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
            
    <div class="form-group row">
        <label for="keterangan" class="col-lg-2 col-sm-12 col-form-label">Keterangan</label>
        <div class="col-lg-10 col-sm-12">
            <input id="keterangan" name="keterangan" type="text" class="form-control">
        </div>
    </div>

	<Div class="form-group row">
        <label for="nama_produk" class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Pengiriman</strong></label>
    </div>
			
    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jalur" class="col-lg-6 col-sm-12 col-form-label">Jalur Pengiriman </label>
                <div class="col-lg-6 col-sm-12">
                    <select id="jalur" name="jalur" class="form-control">
                        <option value="D">Darat</option>
						<option value="L">Laut</option>
						<option value="U">Udara</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="area" class="col-lg-5 col-sm-12 col-form-label">Area</label>
                <div class="col-lg-7 col-sm-12">
                    <select  id="area" name="area" class="form-control">
                        <option value="">Pilih</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut<span class="text-danger">*</span></label>
                <div class="col-lg-4 col-sm-12">
                    <input id="kapasitas" name="kapasitas" type="number" class="form-control" placeholder="Ton">
                </div>
            </div>
        </div>
    </div>

	<div class="form-group row">
        <label for="catatan" class="col-lg-2 col-sm-12 col-form-label">Catatan</label>
        <div class="col-lg-10 col-sm-12">
            <input id="catatan" name="catatan" type="text" class="form-control">
        </div>
    </div>

	<div class="row mt-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>

</form>

<?= $this->endSection() ?>