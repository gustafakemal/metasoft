<? // Form Input Prospek Metaflex ?>

<?php
if(old('jml[]')) {
    dd(old('jml'));
}
?>

<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')): ?>
    <div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<?php if (session()->has('error')): ?>
    <div class="alert alert-danger"><?= session()->get('error'); ?></div>
<?php endif; ?>

<?php //echo form_open('inputprospek'); ?>
<form name="input_proses">

    <div class="form_msg"></div>

    <div class="form-group row">
        <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span class="text-danger">*</span></label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="namaproduk" value="<?= old('NamaProduk');?>" name="NamaProduk" style="text-transform: uppercase">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                <label for="pemesan" class="col-lg-2 col-sm-12 col-form-label">Pemesan</label>
                <div class="col-lg-10 col-sm-12">
                    <select id="pemesan" name="Pemesan" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($customers as $key => $customer) : ?>
                            <?php
                            $selected = (old('Pemesan') && old('Pemesan') == $customer->NoPemesan) ? ' selected' : '';
                            ?>
                            <option<?= $selected;?> value="<?= $customer->NoPemesan; ?>"><?= $customer->NamaPemesan; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-5">
            <div class="form-group row">
                <label for="jenisproduk" class="col-md-5 col-sm-12 col-form-label">Jenis Produk</label>
                <div class="col-md-7 col-sm-12">
                    <div style="display: flex">
                        <select id="jenisproduk" name="JenisProduk" class="form-control mr-1">
                            <option value="">Pilih</option>
                            <?php foreach ($jenisproduk as $key => $jp) : ?>
                                <?php
                                $selected = (old('JenisProduk') && old('JenisProduk') == $jp->id) ? ' selected' : '';
                                ?>
                                <option<?= $selected;?> value="<?= $jp->id; ?>"><?= $jp->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button data-toggle="modal" data-target="#dbProduk" type="button" class="btn btn-sm btn-light" title="Cari produk terkait"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="segmen" class="col-lg-4 col-sm-12 col-form-label">Segmen</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="segmen" name="Segmen" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($segmen as $key => $segmen) : ?>
                            <?php
                            $selected = (old('Segmen') && old('Segmen') == $segmen->ID) ? ' selected' : '';
                            ?>
                            <option<?= $selected;?> value="<?= $segmen->ID; ?>"><?= $segmen->Nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="konten" name="Konten" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($konten as $key => $kt) : ?>
                            <?php
                            $selected = (old('Konten') && old('Konten') == $kt->ID) ? ' selected' : '';
                            ?>
                            <option<?= $selected;?> value="<?= $kt->ID; ?>"><?= $kt->Nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>


            <div class="form-group row">
                <label for="satuan" class="col-lg-2 col-sm-12 col-form-label">Satuan</label>
                <div class="col-lg-10 col-sm-12">

                    <div class="row">
                        <div class="col-3">
                            <select id="roll_pc" name="Roll_Pcs" class="form-control">
                                <option value=""<?= !old('Roll_Pcs') ? ' selected' : '';?>>Pilih</option>
                                <option<?= (old('Roll_Pcs') && old('Roll_Pcs') == 'R') ? ' selected' : '';?> value="R">ROLL</option>
                                <option<?= (old('Roll_Pcs') && old('Roll_Pcs') == 'P') ? ' selected' : '';?> value="P">PCS</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select id="finishing" name="Finishing" class="form-control" disabled>
                                <option value=""<?= !old('Finishing') ? ' selected' : '';?>>Pilih</option>
                                <?php foreach ($finishing as $finish) : ?>
                                    <?php
                                    $selected = old('Finishing') && old('Finishing') == $finish->OpsiVal ? ' selected' : '';
                                    ?>
                                    <option<?= $selected;?> value="<?= $finish->OpsiVal;?>"><?= $finish->OpsiTeks;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="lebar" value="<?= old('Lebar');?>" name="Lebar" placeholder="Lebar">
        </div>
        <div class="col-sm-2">
            <input type="number" step="any" class="form-control" id="panjang" value="<?= old('Panjang');?>" name="Panjang" placeholder="Tinggi">
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

<?php
$material_form = function ($name) use ($material) {
    $id = strtolower($name);
    $open = '<select id="'.$id.'" step="any" name="'.$name.'" class="form-control"><option value="">Pilih</option>';
    $materials = [];
    foreach ($material as $key => $mat) :
        $selected = old($name) && old($name) == $mat->id ? ' selected' : '';
        $materials[] = '<option'.$selected.' value="' . $mat->id . '">' . $mat->nama . '</option>';
    endforeach;
    return $open . implode('', $materials) . '</select>';
}
?>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label">Material<span class="text-danger">*</span></label>
        <div class="col-sm-2">
            <?php echo $material_form('Material1');?>
            <input type="number" value="<?= old('TebalMat1');?>" step="any" class="form-control mt-1" id="tebalmat1" name="TebalMat1" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <?php echo $material_form('Material2');?>
            <input type="number" value="<?= old('TebalMat2');?>" step="any" class="form-control mt-1" id="tebalmat2" name="TebalMat2" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <?php echo $material_form('Material3');?>
            <input type="number" step="any" class="form-control mt-1" value="<?= old('TebalMat3');?>" id="tebalmat3" name="TebalMat3" placeholder="Tebal">
        </div>
        <div class="col-sm-2">
            <?php echo $material_form('Material4');?>
            <input type="number" step="any" class="form-control mt-1" value="<?= old('TebalMat4');?>" id="tebalmat4" name="TebalMat4" placeholder="Tebal">
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna</label>
                <div class="col-lg-6 col-sm-12">
                    <input type="number" value="<?= old('Warna');?>" class="form-control" id="warna" name="Warna" placeholder="Jumlah Warna">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
                <div class="col-lg-7 col-sm-12">
                    <select id="eyemark" name="Eyemark" class="form-control">
                        <option<?= (old('Eyemark') && old('Eyemark') == '1') ? ' selected' : '';?> value="1">Eyemark Only</option>
                        <option<?= (old('Eyemark') && old('Eyemark') == '2') ? ' selected' : '';?> value="2">Eyemark & Block Color</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="roll_direction" class="col-lg-4 col-sm-12 col-form-label">Roll Direction</label>
                <div class="col-lg-8 col-sm-12">
                    <select id="rolldirection" name="RollDirection" id="rolldirection" class="form-control">
                        <option<?= (old('RollDirection') && old('RollDirection') == 'Y') ? ' selected' : '';?> value="Y">Terbaca</option>
                        <option<?= (old('RollDirection') && old('RollDirection') == 'T') ? ' selected' : '';?> value="T">Tidak Terbaca</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="catatan" class="col-lg-2 col-sm-12 col-form-label">Catatan Produk</label>
        <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" id="catatan" name="Catatan" calue="<?= old('Catatan');?>">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong> </label>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="row">
                <label for="maxjoin" class="col-lg-6 col-sm-12 col-form-label">Maksimal Join </label>
                <div class="col-lg-6 col-sm-12">
                    <input type="number" class="form-control" id="maxjoin" name="MaxJoin" value="<?= old('MaxJoin');?>">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row justify-content-end">
                <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
                <div class="col-lg-7 col-sm-12">
                    <input type="text" class="form-control" id="warnatape" name="WarnaTape" value="<?= old('WarnaTape');?>">
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row justify-content-end">
                <label for="JenisTinta" class="col-lg-4 col-sm-12 col-form-label">Jenis Tinta</label>
                <div class="col-lg-7 col-sm-12">
                    <select id="jenistinta" name="JenisTinta" class="form-control">
                        <option value="">Pilih</option>
                        <?php foreach ($jenistinta as $jt) : ?>
                            <?php
                        $selected = old('JenisTinta') && old('JenisTinta') == $jt->OpsiVal ? ' selected' : '';
                            ?>
                            <option<?= $selected;?> value="<?= $jt->OpsiVal;?>"><?= $jt->OpsiTeks;?></option>
                        <?php endforeach;?>
                    </select>
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
                            <?php
                            $selected = old('BagMaking') && old('BagMaking') == $bm->ID ? ' selected' : '';
                            ?>
                            <option<?= $selected;?> value="<?= $bm->ID; ?>"><?= $bm->Nama; ?></option>
                        <?php endforeach; ?>
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
                            <?php
                            $selected = old('Bottom') && old('Bottom') == $bt->ID ? ' selected' : '';
                            ?>
                            <option value="<?= $bt->ID; ?>"><?= $bt->Nama; ?></option>
                        <?php endforeach; ?>
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
                        <option<?= (old('OpenForFilling') && old('OpenForFilling') == 'T') ? ' selected' : '';?> value="T">Top</option>
                        <option<?= (old('OpenForFilling') && old('OpenForFilling') == 'Y') ? ' selected' : '';?> value="B">Bottom</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <label for="aksesoris" class="col-lg-4 col-sm-12 col-form-label">Aksesoris</label>
                <div class="col-lg-8">
                    <div style="display: flex">
                        <select id="aksesoris" name="aksesoris" class="form-control mr-1">
                            <option value="0">Pilih</option>
                            <?php foreach ($aksesori as $key => $ak) : ?>
                                <?php
                                $selected = old('aksesoris') && old('aksesoris') == $ak->id ? ' selected' : '';
                                ?>
                                <option value="<?= $ak->id; ?>"><?= $ak->nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-sm btn-primary add-acc"><i class="fas fa-plus-circle"></i></button>
<!--                        <div class="form-check">-->
<!--                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">-->
<!--                            <label class="form-check-label" for="defaultCheck1">-->
<!--                                Kosongkan-->
<!--                            </label>-->
<!--                        </div>-->
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

    <div class="form-group row">
        <label for="jumlah" class="col-lg-2 col-sm-12 col-form-label">Jumlah</label>
        <div class="col-lg-10 col-sm-12">
            <div class="prospek_jumlah-order">
                <div class="input--jml mr-1 mb-1" id="jml-0">
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm" name="Jumlah" placeholder="Jumlah">
                    </div>
                </div>

                <div class="btn--nav mr-3">
                    <button type="button" class="btn btn-sm btn-primary add-jml">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
                <div class="jml-val-child">
                </div>
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
                    <input id="toleransi" value="<?= old('Toleransi');?>" name="Toleransi" type="number" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group row">
                <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
                <div class="col-lg-6 col-sm-12">
                    <select id="parsial" name="Parsial" class="form-control">
                        <option<?= (old('Parsial') && old('Parsial') == 'T') ? ' selected' : '';?> value="T">Tidak</option>
                        <option<?= (old('Parsial') && old('Parsial') == 'Y') ? ' selected' : '';?> value="Y">Ya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-lg-2 col-sm-12 col-form-label">Keterangan</label>
        <div class="col-lg-10 col-sm-12">
            <input id="keterangan" name="Keterangan" type="text" class="form-control" value="<?= old('Keterangan');?>">
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
                        <option<?= (old('Jalur') && old('Jalur') == 'D') ? ' selected' : '';?> value="D">Darat</option>
                        <option<?= (old('Jalur') && old('Jalur') == 'L') ? ' selected' : '';?> value="L">Laut</option>
                        <option<?= (old('Jalur') && old('Jalur') == 'U') ? ' selected' : '';?> value="U">Udara</option>
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
                            <?php
                            $selected = old('Area') && old('Area') == $a_k->ID ? ' selected' : '';
                            ?>
                            <option value="<?= $a_k->ID; ?>"><?= $a_k->Nama; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut<span
                            class="text-danger">*</span></label>
                <div class="col-lg-4 col-sm-12">
                    <input value="<?= old('Kapasitas');?>" id="kapasitas" name="Kapasitas" type="number" class="form-control" placeholder="Ton">
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
                    <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
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

    <?= form_close();?>

    <!-- Modal -->
    <div class="modal fade" id="dbProduk" tabindex="-1" aria-labelledby="dbProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dbProdukLabel">DB Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        sdsfs
                    </div>
                    <div class="modal-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                            <button name="cancel" type="button" class="btn btn-link text-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
        </div>
    </div>

<?= $this->endSection() ?>