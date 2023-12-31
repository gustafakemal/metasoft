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

<?php
$form_action = "inputprospek?copyprospek=".$copyprospek."&alt=1";
echo form_open($form_action);?>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="no_prospek" class="col-lg-4 col-sm-12 col-form-label">No Prospek</label>
            <div class="col-lg-8 col-sm-12">
                <input type="text" class="form-control" id="no_prospek"
                    value="<?= ($copyprospek == 1) ? '' : $data->NoProspek;?>" name="NoProspek" readonly>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="alt" class="col-lg-4 col-sm-12 col-form-label">Alternatif</label>
            <div class="col-lg-2 col-sm-12">
                <input type="number" class="form-control" id="alt" name="Alt" readonly
                    value="<?= ($copyprospek == 1) ? 1 : '';?>">
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span
            class="text-danger">*</span></label>
    <div class="col-lg-10 col-sm-12">
        <input<?= ($copyprospek == 1) ? '' : ' readonly';?> type="text" class="form-control" id="namaproduk"
            value="<?= $data->NamaProduk;?>" name="NamaProduk" style="text-transform: uppercase">
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="pemesan" class="col-lg-4 col-sm-12 col-form-label">Pemesan</label>
            <div class="col-lg-8 col-sm-12">
                <select<?= ($copyprospek == 1) ? '' : ' readonly';?> id="pemesan" name="Pemesan" class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($customers as $key => $customer) : ?>
                    <option<?= ($customer->NoPemesan == $data->Pemesan) ? ' selected' : '';?>
                        value="<?= $customer->NoPemesan;?>"><?= $customer->NamaPemesan;?></option>
                        <?php endforeach;?>
                        </select>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="jenisproduk" class="col-lg-4 col-sm-12 col-form-label">Jenis Produk</label>
            <div class="col-lg-8 col-sm-12">
                <select<?= ($copyprospek == 1) ? '' : ' readonly';?> id="jenisproduk" name="JenisProduk"
                    class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($jenisproduk as $key => $jp) : ?>
                    <option<?= ($jp->id == $data->JenisProduk) ? ' selected' : '';?> value="<?= $jp->id;?>">
                        <?= $jp->nama;?></option>
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
                <select<?= ($copyprospek == 1) ? '' : ' readonly';?> id="segmen" name="Segmen" class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($segmen as $key => $segmen) : ?>
                    <option<?= ($segmen->ID == $data->Segmen) ? ' selected' : '';?> value="<?= $segmen->ID;?>">
                        <?= $segmen->Nama;?></option>
                        <?php endforeach;?>
                        </select>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
            <div class="col-lg-8 col-sm-12">
                <select<?= ($copyprospek == 1) ? '' : ' readonly';?> id="konten" name="Konten" class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($konten as $key => $kt) : ?>
                    <option<?= ($kt->ID == $data->Konten) ? ' selected' : '';?> value="<?= $kt->ID;?>"><?= $kt->Nama;?>
                        </option>
                        <?php endforeach;?>
                        </select>
            </div>
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
                        <select id="roll_pc" name="Roll_Pcs" class="form-control">
                            <option<?= ($data->Roll_Pcs == 'R') ? ' selected' : '';?> value="R">ROLL</option>
                                <option<?= ($data->Roll_Pcs == 'P') ? ' selected' : '';?> value="P">PCS</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <select id="finishing" name="Finishing" class="form-control" disabled>
                            <option<?= ($data->Finishing == 'CS') ? ' selected' : '';?> value="CS">CS</option>
                                <option<?= ($data->Finishing == 'CS GUSET') ? ' selected' : '';?> value="CSG">CS GUSET
                                    </option>
                                    <option<?= ($data->Finishing == '4SS') ? ' selected' : '';?> value="4SS">4SS
                                        </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)</label>
    <div class="col-sm-2">
        <input value="<?= $data->Lebar;?>" type="number" step="any" class="form-control" id="lebar" name="Lebar"
            placeholder="Lebar">
    </div>
    <div class="col-sm-2">
        <input value="<?= $data->Panjang;?>" type="number" step="any" class="form-control" id="panjang" name="Panjang"
            placeholder="Tinggi">
    </div>
    <div class="col-sm-5">
        <div class="form-group row mb-0">
            <label class="col-lg-4 col-sm-12 col-form-label sat-dym-label"></label>
            <div class="col-sm-8">
                <div class="sat-dym-input">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label">Material</label>
    <div class="col-sm-2">
        <select id="material1" step="any" name="Material1" class="form-control">
            <option value="">Pilih</option>
            <?php foreach ($material as $key => $mt) : ?>
            <option<?= ($mt->id == $data->Material1) ? ' selected' : '';?> value="<?= $mt->id;?>"><?= $mt->nama;?>
                </option>
                <?php endforeach;?>
        </select>
        <input value="<?= ((int)$data->TebalMat1 == 0) ? '0'.$data->TebalMat1 : $data->TebalMat1;?>" type="number"
            step="any" class="form-control" id="tebalmat1" name="TebalMat1" placeholder="Tebal">
    </div>
    <div class="col-sm-2">
        <select id="material2" name="Material2" class="form-control">
            <option value="">Pilih</option>
            <?php foreach ($material as $key => $mt) : ?>
            <option<?= ($mt->id == $data->Material2) ? ' selected' : '';?> value="<?= $mt->id;?>"><?= $mt->nama;?>
                </option>
                <?php endforeach;?>
        </select>
        <input value="<?= ((int)$data->TebalMat2 == 0) ? '0'.$data->TebalMat2 : $data->TebalMat2;?>" type="number"
            step="any" class="form-control" id="tebalmat2" name="TebalMat2" placeholder="Tebal">
    </div>
    <div class="col-sm-2">
        <select id="material3" name="Material3" class="form-control">
            <option value="">Pilih</option>
            <?php foreach ($material as $key => $mt) : ?>
            <option<?= ($mt->id == $data->Material3) ? ' selected' : '';?> value="<?= $mt->id;?>"><?= $mt->nama;?>
                </option>
                <?php endforeach;?>
        </select>
        <input value="<?= ((int)$data->TebalMat3 == 0) ? '0'.$data->TebalMat3 : $data->TebalMat3;?>" type="number"
            step="any" class="form-control" id="tebalmat3" name="TebalMat3" placeholder="Tebal">
    </div>
    <div class="col-sm-2">
        <select id="material4" name="Material4" class="form-control">
            <option value="">Pilih</option>
            <?php foreach ($material as $key => $mt) : ?>
            <option<?= ($mt->id == $data->Material4) ? ' selected' : '';?> value="<?= $mt->id;?>"><?= $mt->nama;?>
                </option>
                <?php endforeach;?>
        </select>
        <input value="<?= ((int)$data->TebalMat4 == 0) ? '0'.$data->TebalMat4 : $data->TebalMat4;?>" type="number"
            step="any" class="form-control" id="tebalmat4" name="TebalMat4" placeholder="Tebal">
    </div>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna</label>
            <div class="col-lg-6 col-sm-12">
                <input value="<?= $data->Warna;?>" type="number" class="form-control" id="warna" name="Warna"
                    placeholder="Jumlah Warna">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
            <div class="col-lg-7 col-sm-12">
                <select id="eyemark" name="Eyemark" class="form-control">
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
                <select id="rolldirection" name="RollDirection" id="rolldirection" class="form-control">
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
        <input value="<?= $data->Catatan;?>" type="text" class="form-control" id="catatan" name="Catatan">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Jumlah Order </strong> </label>
</div>

<div class="form-group row">
    <label for="jumlah" class="col-lg-2 col-sm-12 col-form-label">Jumlah</label>
    <div class="col-lg-10 col-sm-12">
        <div class="prospek_jumlah-order">
            <div class="input--jml mr-1" id="jml-0">
                <div class="input-group">
                    <input type="number" class="form-control form-control-sm" name="Jumlah" placeholder="Jumlah">
                </div>
            </div>
            <div class="btn--nav mr-3">
                <button type="button" class="btn btn-sm btn-primary add-jml">
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>
            <?php if(count($jumlah) > 0) : ?>
            <?php for($i = 0;$i<count($jumlah);$i++) : ?>
            <div class="jml-item-val" id="item-<?= $jumlah[$i]->Jumlah ;?>">
                <input type="hidden" name="jml[]" value="<?= $jumlah[$i]->Jumlah?>" />
                <span class="val"><?= $jumlah[$i]->Jumlah ;?></span>
                <button type="button" class="btn btn-danger btn-sm del-jml" id="jml-<?= $jumlah[$i]->Jumlah ;?>">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <?php endfor;?>
            <?php endif;?>
        </div>

        <div class="prospek_moq">
            <div class="input--moq mr-1" id="moq-0">
                <div class="input-group">
                    <input type="number" class="form-control form-control-sm" name="Moq" placeholder="MOQ">
                </div>
            </div>

            <div class="btn--nav mr-3">
                <button type="button" class="btn btn-sm btn-primary add-moq">
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>
            <div class="moq-val-child">
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="toleransi" class="col-lg-6 col-sm-12 col-form-label">Toleransi</label>
            <div class="col-lg-6 col-sm-12">
                <input value="<?= $data->Toleransi;?>" id="toleransi" name="Toleransi" type="number"
                    class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group row">
            <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
            <div class="col-lg-6 col-sm-12">
                <select id="parsial" name="Parsial" class="form-control">
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
        <input value="<?= $data->Keterangan;?>" id="keterangan" name="Keterangan" type="text" class="form-control">
    </div>
</div>



<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong> </label>
</div>

<div class="row">
    <div class="col-6">
        <div class="row">
            <label for="maxjoin" class="col-lg-4 col-sm-12 col-form-label">Maksimal Join </label>
            <div class="col-lg-8 col-sm-12">
                <input value="<?= $data->MaxJoin;?>" type="number" class="form-control" id="maxjoin" name="MaxJoin">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
            <div class="col-lg-8 col-sm-12">
                <input value="<?= $data->WarnaTape;?>" type="text" class="form-control" id="warnatape" name="WarnaTape">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="bagmaking" class="col-lg-4 col-sm-12 col-form-label">Bag Making</label>
            <div class="col-lg-8 col-sm-12">
                <select id="bagmaking" name="BagMaking" class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($bagmaking as $key => $bm) : ?>
                    <option<?= ($bm->ID == $data->BagMaking) ? ' selected' : '';?> value="<?= $bm->ID;?>">
                        <?= $bm->Nama;?></option>
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
                    <option<?= ($bt->ID == $data->Bottom) ? ' selected' : '';?> value="<?= $bt->ID;?>"><?= $bt->Nama;?>
                        </option>
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
                <div class="row">
                    <div class="col-sm">
                        <select id="aksesoris" name="aksesoris" class="form-control">
                            <option value="0">Pilih</option>
                            <?php foreach ($aksesori as $key => $ak) : ?>
                            <option value="<?= $ak->id;?>"><?= $ak->nama;?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-sm-auto">
                        <button type="button" class="btn btn-sm btn-primary add-acc">+</button>
                    </div>
                </div>

                <div class="bs-child">
                    <?php if(count($prospek_aksesori) > 0) {
                              foreach($prospek_aksesori as $pa) :?>
                    <div class="row mb-1 bscolor" id="bscolor-<?= $pa->id;?>">
                        <div class="col-sm col-form-label"><?= $pa->nama;?></div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn-sm btn-danger delbs" id="delbs-<?= $pa->id;?>">
                                <i class="fas fa-trash-alt text-light"></i>
                            </button>
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


<Div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Pengiriman</strong></label>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="jalur" class="col-lg-6 col-sm-12 col-form-label">Jalur Pengiriman </label>
            <div class="col-lg-6 col-sm-12">
                <select id="jalur" name="Jalur" class="form-control">
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
                <select id="area" name="Area" class="form-control">
                    <option value="">Pilih</option>
                    <?php foreach ($areakirim as $key => $a_k) : ?>
                    <option<?= ($data->Area == $a_k->ID) ? ' selected' : '';?> value="<?= $a_k->ID;?>"><?= $a_k->Nama;?>
                        </option>
                        <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut</label>
            <div class="col-lg-4 col-sm-12">
                <input value="<?= $data->Kapasitas;?>" id="kapasitas" name="Kapasitas" type="number"
                    class="form-control" placeholder="Ton">
            </div>
        </div>
    </div>
</div>

<Div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Attachment</strong></label>
</div>

<div class="form-group row">
    <label for="area" class="col-lg-2 col-sm-12 col-form-label">File</label>
    <div class="col-lg-4 col-sm-12">
        <div class="input-group mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile01"
                    aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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