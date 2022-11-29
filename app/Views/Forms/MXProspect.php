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

<?php echo form_open('mxprospect/add');?>

    <div class="form-group row">
        <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="namaproduk" name="NamaProduk" style="text-transform: uppercase">
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="pemesan" class="col-lg-4 col-sm-12 col-form-label">Pemesan</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="pemesan" name="Pemesan" class="form-control">
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
                <label for="jenisproduk" class="col-lg-4 col-sm-12 col-form-label">Jenis Produk</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="jenisproduk" name="JenisProduk" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($jenisproduk as $key => $jp) : ?>
                            <option value="<?= $jp->ID;?>"><?= $jp->Nama;?></option>
                        <?php endforeach;?>
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
                    <select id="segmen" name="Segmen" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($segmen as $key => $segmen) : ?>
                            <option value="<?= $segmen->ID;?>"><?= $segmen->Nama;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="konten" name="Konten" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($konten as $key => $kt) : ?>
                            <option value="<?= $kt->ID;?>"><?= $kt->Nama;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="tebal" name="Tebal" placeholder="Tebal">
        </div>
		<div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="panjang" name="Panjang" placeholder="Panjang">
        </div>
        <div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="lebar" name="Lebar" placeholder="Lebar">
        </div>
        <div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="pitch" name="Pitch" placeholder="Pitch">
        </div>
    </div>

    <?php
    $materials = [];
    foreach ($material as $key => $mat) :
        $materials[] = '<option value="' . $mat->ID . '">' . $mat->Nama . '</option>';
    endforeach;?>

	<div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Material<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <select id="material1" step="any" name="Material1" class="form-control">
                <option value="">Pilih</option>
                <?= implode('', $materials);?>
            </select>
			<input type="number" step="any" class="form-control" id="tebalmat1" name="TebalMat1" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material2" name="Material2" class="form-control">
                <option value="">Pilih</option>
                <?= implode('', $materials);?>
            </select>
			<input type="number" step="any" class="form-control" id="tebalmat2" name="TebalMat2" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material3" name="Material3" class="form-control">
                <option value="">Pilih</option>
                <?= implode('', $materials);?>
            </select>
			<input type="number" step="any" class="form-control" id="tebalmat3" name="TebalMat3" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select id="material4" name="Material4" class="form-control">
                <option value="">Pilih</option>
                <?= implode('', $materials);?>
            </select>
			<input type="number" step="any" class="form-control" id="tebalmat4" name="TebalMat4" placeholder="Tebal">
        </div>
    </div>
				
    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna</label>
                <div class="col-lg-6 col-sm-12">
                    <input type="number" class="form-control" id="warna" name="Warna" placeholder="Jumlah Warna">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
                <div class="col-lg-7 col-sm-12">
                    <select id="eyemark" name="Eyemark" class="form-control">
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
                    <select id="rolldirection" name="RollDirection" id="rolldirection" class="form-control">
                        <option value="Y">Terbaca</option>
                        <option value="T">Tidak Terbaca</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

	<div class="form-group row">
        <label for="catatan" class="col-lg-2 col-sm-12 col-form-label">Catatan Produk</label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="catatan" name="Catatan">
        </div>
    </div>

	<div class="form-group row">
        <label  class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong> </label>
    </div>
            
    <div class="row">
        <div class="col-6">
            <div class="row">
                <label for="maxjoin" class="col-lg-4 col-sm-12 col-form-label">Maksimal Join </label>
                <div class="col-lg-8 col-sm-12">
                    <input type="number" class="form-control" id="maxjoin" name="MaxJoin">
                </div>
            </div>
        </div>
		<div class="col-6">
            <div class="form-group row">
                <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
                <div class="col-lg-8 col-sm-12">
                    <input type="text" class="form-control" id="warnatape" name="WarnaTape">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="bagmaking" class="col-lg-4 col-sm-12 col-form-label">Bag Making</label>
                <div class="col-lg-8 col-sm-12">
                    <select  id="bagmaking" name="BagMaking" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($bagmaking as $key => $bm) : ?>
                            <option value="<?= $bm->ID;?>"><?= $bm->Nama;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="bottom" class="col-lg-4 col-sm-12 col-form-label">Bottom</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="bottom" name="Bottom" class="form-control" disabled>
                        <option value="">Pilih</option>
                        <?php foreach ($bottom as $key => $bt) : ?>
                            <option value="<?= $bt->ID;?>"><?= $bt->Nama;?></option>
                        <?php endforeach;?>
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
                    <select id="filling" name="OpenForFilling" class="form-control">
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
                                <option value="0">Pilih</option>
                                <?php foreach ($aksesori as $key => $ak) : ?>
                                    <option value="<?= $ak->ID;?>"><?= $ak->Nama;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-sm btn-primary add-acc">+</button>
                        </div>
                    </div>
                    
                    <div class="bs-child">
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
                    <input id="jumlah" name="Jumlah" type="number" class="form-control">
				</div>
            </div>
        </div>
		<div class="col-2">
            <div class="form-group row pr-5">
                <select id="roll_pc" name="Roll_Pcs" class="form-control">
                    <option selected value="R">ROLL</option>
					<option value="P">PCS</option>
                </select>
				<select id="finishing" name="Finishing" class="form-control" disabled>
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
                    <input id="toleransi" name="Toleransi" type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
                <div class="col-lg-6 col-sm-12">
                    <select id="parsial" name="Parsial" class="form-control">
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
            <input id="keterangan" name="Keterangan" type="text" class="form-control">
        </div>
    </div>

	<Div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Pengiriman</strong></label>
    </div>
			
    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jalur" class="col-lg-6 col-sm-12 col-form-label">Jalur Pengiriman </label>
                <div class="col-lg-6 col-sm-12">
                    <select id="jalur" name="Jalur" class="form-control">
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
                    <select  id="area" name="Area" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($areakirim as $key => $a_k) : ?>
                            <option value="<?= $a_k->ID;?>"><?= $a_k->Nama;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut<span class="text-danger">*</span></label>
                <div class="col-lg-4 col-sm-12">
                    <input id="kapasitas" name="Kapasitas" type="number" class="form-control" placeholder="Ton">
                </div>
            </div>
        </div>
    </div>

	<div class="row mt-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>

</form>

<?= $this->endSection() ?>