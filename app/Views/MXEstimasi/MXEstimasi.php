<? // Form Input Estimasi Metaflex ?>

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

<?php echo form_open('inputestimasi');?>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="no_prospek" class="col-lg-4 col-sm-12 col-form-label">No Prospek</label>
                <div class="col-lg-8 col-sm-12">
                    <input type="text" class="form-control" id="no_prospek" value="<?= $data->NoProspek;?>" name="NoProspek" readonly>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="alt" class="col-lg-4 col-sm-12 col-form-label">Alternatif</label>
                <div class="col-lg-2 col-sm-12">
                    <input value="<?= $data->Alt;?>" type="number" class="form-control" id="alt" name="Alt" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="namaproduk" value="<?= $data->NamaProduk;?>" name="NamaProduk" readonly>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="pemesan" class="col-lg-4 col-sm-12 col-form-label">Pemesan</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="pemesan" name="Pemesan" class="form-control" readonly>
                        <option value="<?= $data->Pemesan ?: '';?>"><?= ($data->Pemesan) ? $data->NamaPemesan : '-';?></option>
                    </select>
                </div>
            </div>
        </div>    
        <div class="col-6">
            <div class="form-group row">
                <label for="jenisproduk" class="col-lg-4 col-sm-12 col-form-label">Jenis Produk</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="jenisproduk" name="JenisProduk" class="form-control" readonly>
                        <option value="<?= $data->JenisProduk;?>"><?= $data->NamaJenisProduk;?></option>
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
                    <select id="segmen" name="Segmen" class="form-control" readonly>
                        <option value="<?= $data->Segmen;?>"><?= $data->NamaSegmen;?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="konten" name="Konten" class="form-control" readonly>
                        <option value="<?= $data->Konten;?>"><?= $data->NamaKonten;?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <input readonly value="<?= $data->Tebal;?>" type="number" step="any" class="form-control" id="tebal" name="Tebal" placeholder="Tebal">
        </div>
		<div class="col-sm-2">
            <input readonly value="<?= $data->Panjang;?>" type="number" step="any" class="form-control" id="panjang" name="Panjang" placeholder="Panjang">
        </div>
        <div class="col-sm-2">
            <input readonly value="<?= $data->Lebar;?>" type="number" step="any" class="form-control" id="lebar" name="Lebar" placeholder="Lebar">
        </div>
        <div class="col-sm-2">
            <input readonly value="<?= $data->Pitch;?>" type="number" step="any" class="form-control" id="pitch" name="Pitch" placeholder="Pitch">
        </div>
    </div>

	<div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Material<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <select readonly id="material1" step="any" name="Material1" class="form-control">
                <option value="<?= $data->Material1;?>"><?= $data->NamaMaterial1;?></option>
            </select>
			<input readonly value="<?= ((int)$data->TebalMat1 == 0) ? '0'.$data->TebalMat1 : $data->TebalMat1;?>" type="number" step="any" class="form-control" id="tebalmat1" name="TebalMat1" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select readonly id="material2" name="Material2" class="form-control">
                <option value="<?= $data->Material2;?>"><?= $data->NamaMaterial2;?></option>
            </select>
			<input readonly value="<?= ((int)$data->TebalMat2 == 0) ? '0'.$data->TebalMat2 : $data->TebalMat2;?>" type="number" step="any" class="form-control" id="tebalmat2" name="TebalMat2" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select readonly id="material3" name="Material3" class="form-control">
                <option value="<?= $data->Material3;?>"><?= $data->NamaMaterial3;?></option>
            </select>
			<input readonly value="<?= ((int)$data->TebalMat3 == 0) ? '0'.$data->TebalMat3 : $data->TebalMat3;?>" type="number" step="any" class="form-control" id="tebalmat3" name="TebalMat3" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <select readonly id="material4" name="Material4" class="form-control">
                <option value="<?= $data->Material4;?>"><?= $data->NamaMaterial4;?></option>
            </select>
			<input readonly value="<?= ((int)$data->TebalMat4 == 0) ? '0'.$data->TebalMat4 : $data->TebalMat4;?>" type="number" step="any" class="form-control" id="tebalmat4" name="TebalMat4" placeholder="Tebal">
        </div>
    </div>
				
    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna</label>
                <div class="col-lg-6 col-sm-12">
                    <input readonly value="<?= $data->Warna;?>" type="number" class="form-control" id="warna" name="Warna" placeholder="Jumlah Warna">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
                <div class="col-lg-7 col-sm-12">
                    <select readonly id="eyemark" name="Eyemark" class="form-control">
                        <option<?= ($data->Eyemark == 1) ? ' selected' : '';?> value="1">Eyemark Only</option>
                        <option<?= ($data->Eyemark == 2) ? ' selected' : '';?> value="2">Eyemark & Block Color</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="roll_direction" class="col-lg-4 col-sm-12 col-form-label">Roll Direction</label>
                <div class="col-lg-8 col-sm-12">
                    <select readonly id="rolldirection" name="RollDirection" id="rolldirection" class="form-control">
                        <option<?= ($data->RollDirection == 'Y') ? ' selected' : '';?> value="Y">Terbaca</option>
                        <option<?= ($data->RollDirection == 'T') ? ' selected' : '';?> value="T">Tidak Terbaca</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

	<div class="form-group row">
        <label for="catatan" class="col-lg-2 col-sm-12 col-form-label">Catatan Produk</label>
        <div class="col-lg-10 col-sm-12">
            <input readonly value="<?= $data->Catatan;?>" type="text" class="form-control" id="catatan" name="Catatan">
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
                    <input readonly value="<?= $data->MaxJoin;?>" type="number" class="form-control" id="maxjoin" name="MaxJoin">
                </div>
            </div>
        </div>
		<div class="col-6">
            <div class="form-group row">
                <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
                <div class="col-lg-8 col-sm-12">
                    <input readonly value="<?= $data->WarnaTape;?>" type="text" class="form-control" id="warnatape" name="WarnaTape">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="bagmaking" class="col-lg-4 col-sm-12 col-form-label">Bag Making</label>
                <div class="col-lg-8 col-sm-12">
                    <select readonly  id="bagmaking" name="BagMaking" class="form-control">
                        <option value="<?= $data->BagMaking;?>"><?= $data->NamaBagMaking;?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="bottom" class="col-lg-4 col-sm-12 col-form-label">Bottom</label>
                <div class="col-lg-8 col-sm-12">
                    <select readonly id="bottom" name="Bottom" class="form-control" disabled>
                        <option value="<?= $data->Bottom;?>"><?= $data->Bottom;?></option>
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
                    <select readonly id="filling" name="OpenForFilling" class="form-control">
                        <option value="">Pilih</option>
						<option<?= ($data->OpenForFilling == 'T') ? ' selected' : '';?> value="T">Top</option>
						<option<?= ($data->OpenForFilling == 'B') ? ' selected' : '';?> value="B">Bottom</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="aksesoris" class="col-lg-4 col-sm-12 col-form-label">Aksesoris</label>
                <div class="col-sm-6">
                    <div class="bs-child">
                        <?php if(count($prospek_aksesori) > 0) {
                              foreach($prospek_aksesori as $pa) :?>
                                  <div class="row mb-1 bscolor" id="bscolor-<?= $pa->id;?>">
                                      <div class="col-sm col-form-label"><?= $pa->nama;?></div>
                                      <div class="col-sm-auto">
                                      </div>
                                      <input type="hidden" name="aksesori[]" value="<?= $pa->id;?>">
                                  </div>
                              <?php endforeach;
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Jumlah Order </strong> </label>
    </div>

    <div class="form-group row">
        <label for="jumlah" class="col-lg-2 col-sm-12 col-form-label">Jumlah</label>
        <div class="col-lg-10 col-sm-12">
            <div class="prospek_jumlah-order">
                <?php if(count($jumlah) > 0) : ?>
                    <?php for($i = 0;$i<count($jumlah);$i++) : ?>
                        <div class="jml-item-val" id="item-<?= $jumlah[$i]->Jumlah ;?>">
                            <input type="hidden" name="jml[]" value="<?= $jumlah[$i]->Jumlah?>" />
                            <span class="val"><?= $jumlah[$i]->Jumlah ;?></span>
                        </div>
                    <?php endfor;?>
                <?php endif;?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group row">
                <label for="satuan" class="col-lg-4 col-sm-12 col-form-label">Satuan</label>
                <div class="col-lg-8 col-sm-12">

                    <div class="row">
                        <div class="col-6">
                            <select readonly id="roll_pc" name="Roll_Pcs" class="form-control">
                                <option<?= ($data->Roll_Pcs == 'R') ? ' selected' : '';?> value="R">ROLL</option>
                                <option<?= ($data->Roll_Pcs == 'P') ? ' selected' : '';?> value="P">PCS</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select  readonly id="finishing" name="Finishing" class="form-control" disabled>
                                <option<?= ($data->Finishing == 'CS') ? ' selected' : '';?> value="CS">CS</option>
                                <option<?= ($data->Finishing == 'CS GUSET') ? ' selected' : '';?> value="CSG">CS GUSET</option>
                                <option<?= ($data->Finishing == '4SS') ? ' selected' : '';?> value="4SS">4SS</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="toleransi" class="col-lg-4 col-sm-12 col-form-label">Toleransi</label>
                <div class="col-lg-8 col-sm-12">
                    <input readonly value="<?= $data->Toleransi;?>" id="toleransi" name="Toleransi" type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
                <div class="col-lg-6 col-sm-12">
                    <select readonly id="parsial" name="Parsial" class="form-control">
                        <option<?= ($data->Parsial == 'T') ? ' selected' : '';?> value="T">Tidak</option>
                        <option<?= ($data->Parsial == 'Y') ? ' selected' : '';?> value="Y">Ya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
            
    <div class="form-group row">
        <label for="keterangan" class="col-lg-2 col-sm-12 col-form-label">Keterangan</label>
        <div class="col-lg-10 col-sm-12">
            <input readonly value="<?= $data->Keterangan;?>" id="keterangan" name="Keterangan" type="text" class="form-control">
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
                    <select readonly id="jalur" name="Jalur" class="form-control">
                        <option<?= ($data->Jalur == 'D') ? ' selected' : '';?> value="D">Darat</option>
						<option<?= ($data->Jalur == 'L') ? ' selected' : '';?> value="L">Laut</option>
						<option<?= ($data->Jalur == 'U') ? ' selected' : '';?> value="U">Udara</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="area" class="col-lg-5 col-sm-12 col-form-label">Area</label>
                <div class="col-lg-7 col-sm-12">
                    <select  readonly  id="area" name="Area" class="form-control">
                        <option value="<?= $data->Area;?>"><?= $data->NamaArea;?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut<span class="text-danger">*</span></label>
                <div class="col-lg-4 col-sm-12">
                    <input readonly value="<?= $data->Kapasitas;?>" id="kapasitas" name="Kapasitas" type="number" class="form-control" placeholder="Ton">
                </div>
            </div>
        </div>
    </div>

    <? // Bagian yg diisi oleh Estimator ?>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 22px">Kelengkapan Data</strong> </label>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jml_up" class="col-lg-6 col-sm-12 col-form-label">Jumlah Up</label>
                <div class="col-lg-6 col-sm-12">
                    <input type="number" name="JumlahUp" class="form-control" id="jml_up" />
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="lbr_film" class="col-lg-5 col-sm-12 col-form-label">Lebar Film</label>
                <div class="col-lg-7 col-sm-12">
                    <input type="number" name="LebarFilm" class="form-control" id="lbr_film" />
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="lbr_film" class="col-lg-5 col-sm-12 col-form-label">Lebar Film</label>
                <div class="col-lg-7 col-sm-12">
                    <input type="number" name="LebarFilm" class="form-control" id="lbr_film" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jenistinta" class="col-lg-6 col-sm-12 col-form-label">Jenis Tinta</label>
                <div class="col-lg-6 col-sm-12">
                    <select id="jenistinta" name="jenistinta" class="form-control" disabled>
                        <option value="<?= $jenistinta->OpsiVal;?>"><?= $jenistinta->OpsiTeks;?></option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-4">
            <div class="form-group row">
                <label for="adhesive" class="col-lg-5 col-sm-12 col-form-label">Adhesive </label>
                <div class="col-lg-7 col-sm-12">
                    <select id="adhesive" name="adhesive" class="form-control">
                        <option value=""<?= (!$data->JenisAdhesive) ? ' selected' : '';?>>Pilih</option>
                        <?php foreach ($adhesive as $ads) : ?>
                            <option value="<?= $ads->OpsiVal;?>"><?= $ads->OpsiTeks;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped tbl-tinta" style="width: 40%;">
                    <thead>
                        <tr>
                            <th><button type="button" class="btn btn-sm btn-primary add-acc"><i class="fas fa-plus-circle"></i></button></th>
                            <th style="width: 250px;">Warna Tinta</th>
                            <th>% Coverage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd" data-key="0">
                            <td>
                                <button class="btn btn-sm btn-danger del-tinta" data-id="0" type="button" disabled>
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>
                                <select id="warnatinta" name="warnatinta" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php foreach ($tinta as $t) : ?>
                                        <option value="<?= $t->id;?>"><?= $t->nama;?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td>
                                <input value="" id="coverage" name="coverage" type="number" class="form-control">
                            </td>
                    
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

	<div class="row mt-4">
        <div class="col-12">
            <button type="button" data-toggle="modal" data-target="#kalkulasiModal" class="btn btn-primary">Kalkulasi</button>
        </div>
    </div>
</form>


<!-- Modal Hasil Kalkulasi otomatis-->
<div class="modal fade" id="kalkulasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content width=60%">
        <div class="modal-header">
          <h5 class="modal-title">Hasil Kalkulasi</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="jumlahup" class="col-lg-6 col-sm-12 col-form-label">Jumlah Up</label>
                        <div class="col-lg-6 col-sm-12">
                        <input value="<?php ?>" id="jumlahup" name="jumlahup" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="lebarfilm" class="col-lg-5 col-sm-12 col-form-label">Lebar Film </label>
                        <div class="col-lg-7 col-sm-12">
                        <input value="<?php ?>" id="lebarfilm" name="lebarfilm" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="jumlahpitch" class="col-lg-6 col-sm-12 col-form-label">Jumlah Pitch</label>
                        <div class="col-lg-6 col-sm-12">
                        <input disabled value="<?php ?>" id="jumlahpitch" name="jumlahpitch" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="colorbar" class="col-lg-5 col-sm-12 col-form-label">Color Bar </label>
                        <div class="col-lg-7 col-sm-12">
                        <input disabled value="<?php ?>" id="colorbar" name="colorbar" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="circum" class="col-lg-6 col-sm-12 col-form-label">Circum</label>
                        <div class="col-lg-6 col-sm-12">
                        <input disabled value="<?php ?>" id="circum" name="circum" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="runmeter" class="col-lg-5 col-sm-12 col-form-label">Running Meter</label>
                        <div class="col-lg-7 col-sm-12">
                        <input disabled value="<?php ?>" id="runmeter" name="runmeter" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="waste" class="col-lg-6 col-sm-12 col-form-label">Waste</label>
                        <div class="col-lg-6 col-sm-12">
                        <input disabled value="<?php ?>" id="waste" name="waste" type="number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="wasteps" class="col-lg-5 col-sm-12 col-form-label">Waste Persiapan</label>
                        <div class="col-lg-7 col-sm-12">
                        <input disabled value="<?php ?>" id="wasteps" name="wasteps" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="jum_truk" class="col-lg-6 col-sm-12 col-form-label">Jumlah Truk</label>
                        <div class="col-lg-6 col-sm-12">
                        <input disabled value="<?php ?>" id="jum_truk" name="jum_truk" type="number" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <a href=""  class="btn btn-primary  mb-2">Buat Estimasi</a>
        </div>
      </div>
    </div>
  </div>

<!-- SCRIPTS -->



<?= $this->endSection() ?>