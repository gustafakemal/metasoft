<? // Form Input Prospek Metaflex ?>

<?php
if (old('jml[]')) {
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

    <div class="form_msg"></div>

<?php

if(isset($forms)) {
    list(
            'form_open' => $form_open,
            'submit_button' => $submit_button,
            'form_close' => $form_close
        ) = $forms;
} else {
    $form_open = '';
    $submit_button = '';
    $form_close = '';
}
/* ------------------------------------------------------------------------------- */

if(isset($copyprospek)) {
    if($copyprospek['duplicate'] == 'new') {
        $NoProspek = '';
        $Alt = 1;
    } elseif($copyprospek['duplicate'] == 'alt') {
        $NoProspek = $value->NoProspek;
        $Alt = '';
    } else {
        $NoProspek = '';
        $Alt = '';
    }
} else {
    if(isset($value)) {
        $NoProspek = $value->NoProspek;
        $Alt = $value->Alt;
    } else {
        $NoProspek = '';
        $Alt = '';
    }
}
$NamaProduk = isset($value) ? $value->NamaProduk : '';
$Pemesan = isset($value) ? $value->Pemesan : '';
$JenisProduk = isset($value) ? $value->JenisProduk : '';
$Segmen = isset($value) ? $value->Segmen : '';
$Konten = isset($value) ? $value->Konten : '';
$Roll_Pcs = isset($value) ? $value->Roll_Pcs : '';
$Finishing = isset($value) ? $value->Finishing : '';
$Lebar = isset($value) ? $value->Lebar : '';
$Panjang = isset($value) ? $value->Panjang : '';
$MeterRoll = isset($value) ? $value->MeterRoll : '';
$CentreSeal = isset($value) ? $value->CentreSeal : '';
$Gusset = isset($value) ? $value->Gusset : '';
$Material1 = isset($value) ? $value->Material1 : '';
$Material2 = isset($value) ? $value->Material2 : '';
$Material3 = isset($value) ? $value->Material3 : '';
$Material4 = isset($value) ? $value->Material4 : '';
$TebalMat1 = isset($value) ? $value->TebalMat1 : '';
$TebalMat2 = isset($value) ? $value->TebalMat2 : '';
$TebalMat3 = isset($value) ? $value->TebalMat3 : '';
$TebalMat4 = isset($value) ? $value->TebalMat4 : '';
$Warna = isset($value) ? $value->Warna : '';
$Eyemark = isset($value) ? $value->Eyemark : '';
$RollDirection = isset($value) ? $value->RollDirection : '';
$Catatan = isset($value) ? $value->Catatan : '';
$Toleransi = isset($value) ? $value->Toleransi : '';
$Parsial = isset($value) ? $value->Parsial : '';
$Keterangan = isset($value) ? $value->Keterangan : '';
$MaxJoin = isset($value) ? $value->MaxJoin : '';
$WarnaTape = isset($value) ? $value->WarnaTape : '';
$JenisTinta = isset($value) ? $value->JenisTinta : '';
$BagMaking = isset($value) ? $value->BagMaking : '';
$Bottom = isset($value) ? $value->Bottom : '';
$OpenForFilling = isset($value) ? $value->OpenForFilling : '';
$Jalur = isset($value) ? $value->Jalur : '';
$Area = isset($value) ? $value->Area : '';
$Kapasitas = isset($value) ? $value->Kapasitas : '';
$JumlahUp = isset($value) ? $value->JumlahUp : '';
$LebarFilm = isset($value) ? $value->LebarFilm : '';
$Lampiran1 = isset($value) ? $value->Lampiran1 : '';
$FileLampiran1 = isset($value) ? $value->FileLampiran1 : '';
?>

<?php //echo form_open_multipart('inputprospek'); ?>

    <?= $form_open;?>

    <?php if( isset($estimasi) ) : ?>
        <div class="row">
            <div class="col-6">
                <div class="form-group row">
                    <label for="no_prospek" class="col-lg-4 col-sm-12 col-form-label">No Prospek</label>
                    <div class="col-lg-8 col-sm-12">
                        <input type="text" class="form-control" id="no_prospek" value="<?= $NoProspek; ?>" name="NoProspek"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label for="alt" class="col-lg-4 col-sm-12 col-form-label">Alternatif</label>
                    <div class="col-lg-2 col-sm-12">
                        <input value="<?= $Alt; ?>" type="number" class="form-control" id="alt" name="Alt" readonly>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

        <div class="form-group row">
            <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk <span class="text-danger">*</span></label>
            <div class="col-lg-10 col-sm-12">
                <?php if(isset($copyprospek)) : ?>
                    <input type="hidden" name="duplicate" value="<?= $copyprospek['duplicate'];?>" />
                <?php endif;?>
                <input
                        type="text"
                        class="form-control"
                        id="namaproduk"
                        value="<?= $NamaProduk; ?>"
                        name="NamaProduk"
                        style="text-transform: uppercase"
                />
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label for="pemesan" class="col-lg-2 col-sm-12 col-form-label">Pemesan <span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-sm-12">
                        <select id="pemesan" name="Pemesan" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach ($customers as $key => $customer) :
                                $selected = ($Pemesan == $customer->NoPemesan) ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?>
                                        value="<?= $customer->NoPemesan; ?>"><?= $customer->NamaPemesan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <div class="form-group row">
                    <label for="jenisproduk" class="col-md-5 col-sm-12 col-form-label">Jenis Produk <span class="text-danger">*</span></label>
                    <div class="col-md-7 col-sm-12" style="padding-left: 7px">
                        <div style="display: flex">
                            <select id="jenisproduk" name="JenisProduk" class="form-control mr-1">
                                <option value="">Pilih</option>
                                <?php foreach ($jenisproduk as $key => $jp) :
                                    $selected = ($JenisProduk == $jp->id) ? ' selected' : '';
                                    ?>
                                    <option<?= $selected; ?> value="<?= $jp->id; ?>">
                                        <?= $jp->nama; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php $prod_disabled = ($JenisProduk == '') ? ' disabled' : '';?>
                            <button<?php $prod_disabled;?> type="button" class="btn btn-sm btn-light show-produk" title="Cari produk terkait"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label for="segmen" class="col-lg-4 col-sm-12 col-form-label">Segmen <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-sm-12">
                        <select id="segmen" name="Segmen" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach ($segmen as $key => $segmen) :
                                $selected = ($Segmen == $segmen->ID) ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?> value="<?= $segmen->ID; ?>"><?= $segmen->Nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group row">
                    <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten <span class="text-danger">*</span></label>
                    <div class="col-lg-8 col-sm-12">
                        <select id="konten" name="Konten" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach ($konten as $key => $kt) :
                                $selected = ($Konten == $kt->ID) ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?> value="<?= $kt->ID; ?>"><?= $kt->Nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="satuan" class="col-lg-2 col-sm-12 col-form-label">Satuan <span class="text-danger">*</span></label>
            <div class="col-lg-10 col-sm-12">

                <div class="row">
                    <div class="col-3">
                        <select id="roll_pc" name="Roll_Pcs" class="form-control">
                            <option value="" <?= !$Roll_Pcs ? ' selected' : ''; ?>>Pilih</option>
                            <option<?= ($Roll_Pcs == 'R') ? ' selected' : ''; ?> value="R">
                                ROLL
                            </option>
                            <option<?= ($Roll_Pcs == 'P') ? ' selected' : ''; ?> value="P">PCS
                            </option>
                        </select>
                    </div>
                    <div class="col-3">
                        <?php
                        if( isset($estimasi) && $Roll_Pcs == 'P' ) :
                            $disabled_finishing = '';
                        else :
                            $disabled_finishing = ' disabled';
                        endif;
                        ?>
                        <select id="finishing" name="Finishing" class="form-control"<?= $disabled_finishing;?>>
                            <option value="" <?= !old('Finishing') ? ' selected' : ''; ?>>Pilih</option>
                            <?php foreach ($finishing as $finish) :
                                $selected = $Finishing == $finish->OpsiVal ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?>
                                        value="<?= $finish->OpsiVal; ?>"><?= $finish->OpsiTeks; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm) <?php if( isset($estimasi) ) : ?><span class="text-danger">*</span><?php endif;?> </label>
            <div class="col-sm-2">
                <input type="number" step="any" class="form-control" id="lebar" value="<?= $Lebar; ?>" name="Lebar" placeholder="Lebar">
            </div>
            <div class="col-sm-2">
                <input type="number" step="any" class="form-control" id="panjang" value="<?= $Panjang; ?>"
                       name="Panjang"
                       placeholder="Tinggi">
            </div>
            <div class="col-sm-5">
                <div class="form-group row mb-0">
                    <?php
                    if( isset($estimasi) && $Roll_Pcs == 'R' ) :
                        $sat_dym_label = 'Meter Roll';
                        $sat_dym_input = '<input type="number" step="any" class="form-control" id="meterroll" name="MeterRoll" placeholder="Meter Roll" value="' . $MeterRoll . '">';
                    elseif ( isset($estimasi) && $Roll_Pcs == 'P' ):
                        if($Finishing == 'STP'):
                            $sat_dym_label = 'Bottom';
                            $sat_dym_input = '<input type="number" step="any" class="form-control" id="ukuranbottom" name="UkuranBottom" placeholder="Bottom" value="' . $Bottom . '">';
                        elseif($Finishing == 'CS'):
                            $sat_dym_label = 'Centre Seal';
                            $sat_dym_input = '<input type="number" step="any" class="form-control" id="centreseal" name="CentreSeal" placeholder="Centre Seal" value="' . $CentreSeal . '">';
                        elseif($Finishing == 'CS Gusset'):
                            $sat_dym_label = 'Gusset';
                            $sat_dym_input = '<input type="number" step="any" class="form-control" id="gusset" name="Gusset" placeholder="Gusset" value="' . $Gusset . '">';
                        else:
                            $sat_dym_label = '';
                            $sat_dym_input = '';
                        endif;
                    else:
                        $sat_dym_label = '';
                        $sat_dym_input = '';
                    endif;
                    ?>
                    <label class="col-lg-4 col-sm-12 col-form-label sat-dym-label"><?= $sat_dym_label;?></label>
                    <div class="col-sm-8">
                        <div class="sat-dym-input"><?= $sat_dym_input;?></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $material_form = function ($name, $mat_no) use ($material) {
            $id = strtolower($name);
            $open = '<select id="' . $id . '" step="any" name="' . $name . '" class="form-control"><option value="">Pilih</option>';
            $materials = [];
            foreach ($material as $key => $mat) :
                $selected = $mat_no == $mat->id ? ' selected' : '';
                $materials[] = '<option' . $selected . ' value="' . $mat->id . '">' . $mat->nama . '</option>';
            endforeach;
            return $open . implode('', $materials) . '</select>';
        }
        ?>

        <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Material <?php if( isset($estimasi) ) : ?><span class="text-danger">*</span><?php endif;?></label>
            <div class="col-sm-2">
                <?php echo $material_form('Material1', $Material1); ?>
                <input type="number" value="<?= $TebalMat1; ?>" step="any" class="form-control mt-1"
                       id="tebalmat1"
                       name="TebalMat1" placeholder="Tebal">
            </div>
            <div class="col-sm-2">
                <?php echo $material_form('Material2', $Material2); ?>
                <input type="number" value="<?= $TebalMat2; ?>" step="any" class="form-control mt-1"
                       id="tebalmat2" name="TebalMat2" placeholder="Tebal">
            </div>
            <div class="col-sm-2">
                <?php echo $material_form('Material3', $Material3); ?>
                <input type="number" step="any" class="form-control mt-1" value="<?= $TebalMat3; ?>"
                       id="tebalmat3" name="TebalMat3" placeholder="Tebal">
            </div>
            <div class="col-sm-2">
                <?php echo $material_form('Material4', $Material4); ?>
                <input type="number" step="any" class="form-control mt-1" value="<?= $TebalMat4; ?>"
                       id="tebalmat4" name="TebalMat4" placeholder="Tebal">
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="form-group row">
                    <label for="warna" class="col-lg-6 col-sm-12 col-form-label">Warna <?php if( isset($estimasi) ) : ?><span class="text-danger">*</span><?php endif;?></label>
                    <div class="col-lg-6 col-sm-12">
                        <input type="number" value="<?= $Warna; ?>" class="form-control" id="warna" name="Warna"
                               placeholder="Jumlah Warna">
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label for="eyemark" class="col-lg-5 col-sm-12 col-form-label">Eyemark</label>
                    <div class="col-lg-7 col-sm-12">
                        <select id="eyemark" name="Eyemark" class="form-control">
                            <option<?= ($Eyemark == '1') ? ' selected' : ''; ?> value="1">
                                Eyemark Only
                            </option>
                            <option<?= ($Eyemark == '2') ? ' selected' : ''; ?> value="2">
                                Eyemark &
                                Block Color
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label for="roll_direction" class="col-lg-4 col-sm-12 col-form-label">Roll Direction</label>
                    <div class="col-lg-8 col-sm-12">
                        <select id="rolldirection" name="RollDirection" id="rolldirection" class="form-control">
                            <option<?= ($RollDirection == 'Y') ? ' selected' : ''; ?> value="Y"> Terbaca</option>
                            <option<?= ($RollDirection == 'T') ? ' selected' : ''; ?> value="T"> Tidak Terbaca</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="catatan" class="col-lg-2 col-sm-12 col-form-label">Catatan Produk</label>
            <div class="col-lg-10 col-sm-12">
                <input type="text" class="form-control" id="catatan" name="Catatan" value="<?= $Catatan; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Jumlah Order </strong>
            </label>
        </div>

        <div class="form-group row">
            <label for="jumlah" class="col-lg-2 col-sm-12 col-form-label">Jumlah <span class="text-danger">*</span></label>
            <div class="col-lg-10 col-sm-12">
                <div class="prospek_jumlah-order">
                    <div class="input--jml mr-1 mb-1" id="jml-0">
                        <div class="input-group">
                            <input type="number" class="form-control form-control-sm" name="Jumlah" placeholder="Roll/Pc">
                        </div>
                    </div>

                    <div class="btn--nav mr-3">
                        <button type="button" class="btn btn-sm btn-primary add-jml">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                    <div class="jml-val-child">
                    </div>
                    <?php if(isset($value) && count($value->jml) > 0) :
                        foreach ($value->jml as $j_row) :
                            if($j_row->MOQ != 0) continue;
                        ?>
                        <div class="jml-item-val" id="item-<?= (int)$j_row->Jumlah;?>">
                            <input type="hidden" name="jml[]" value="<?= (int)$j_row->Jumlah;?>">
                            <span class="val"><?= (int)$j_row->Jumlah;?></span>
                            <button type="button" class="btn btn-danger btn-sm del-jml" id="jml-<?= (int)$j_row->Jumlah;?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <?php endforeach;?>
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
                    <?php if(isset($value) && count($value->jml) > 0) :
                        foreach ($value->jml as $j_row) :
                            if($j_row->MOQ == 0) continue;
                        ?>
                        <div class="moq-item-val" id="m-item-<?= $j_row->MOQ;?>">
                            <input type="hidden" name="moq[]" value="<?= $j_row->MOQ;?>">
                            <span class="m-val"><?= $j_row->MOQ;?></span>
                            <button type="button" class="btn btn-danger btn-sm del-moq" id="moq-<?= $j_row->MOQ;?>">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="form-group row">
                    <label for="toleransi" class="col-lg-6 col-sm-12 col-form-label">Toleransi</label>
                    <div class="col-lg-6 col-sm-12">
                        <input id="toleransi" value="<?= $Toleransi; ?>" name="Toleransi" type="number"
                               class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group row">
                    <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
                    <div class="col-lg-6 col-sm-12">
                        <select id="parsial" name="Parsial" class="form-control">
                            <option<?= ($Parsial == 'T') ? ' selected' : ''; ?> value="T">
                                Tidak
                            </option>
                            <option<?= ($Parsial == 'Y') ? ' selected' : ''; ?> value="Y">Ya
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="keterangan" class="col-lg-2 col-sm-12 col-form-label">Keterangan</label>
            <div class="col-lg-10 col-sm-12">
                <input id="keterangan" name="Keterangan" type="text" class="form-control"
                       value="<?= $Keterangan; ?>">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong>
            </label>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="row">
                    <label for="maxjoin" class="col-lg-6 col-sm-12 col-form-label">Maksimal Join </label>
                    <div class="col-lg-6 col-sm-12">
                        <input type="number" class="form-control" id="maxjoin" name="MaxJoin" value="<?= $MaxJoin; ?>">
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row justify-content-end">
                    <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
                    <div class="col-lg-7 col-sm-12">
                        <input type="text" class="form-control" id="warnatape" name="WarnaTape"
                               value="<?= $WarnaTape; ?>">
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
                                $selected = $JenisTinta == $jt->OpsiVal ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?> value="<?= $jt->OpsiVal; ?>"><?= $jt->OpsiTeks; ?></option>
                            <?php endforeach; ?>
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
                                $selected = $BagMaking == $bm->ID ? ' selected' : '';
                                ?>
                                <option<?= $selected; ?> value="<?= $bm->ID; ?>"><?= $bm->Nama; ?></option>
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
                            <?php foreach ($bottom as $key => $bt) :
                                $selected = $Bottom == $bt->ID ? ' selected' : '';
                                ?>
                                <option<?= $selected;?> value="<?= $bt->ID; ?>"><?= $bt->Nama; ?></option>
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
                            <option<?= ($OpenForFilling == 'T') ? ' selected' : ''; ?>
                                    value="T">
                                Top
                            </option>
                            <option<?= ($OpenForFilling == 'Y') ? ' selected' : ''; ?>
                                    value="B">Bottom
                            </option>
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
                            <button type="button" class="btn btn-sm btn-primary add-acc"><i
                                        class="fas fa-plus-circle"></i></button>
                            <!--                        <div class="form-check">-->
                            <!--                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">-->
                            <!--                            <label class="form-check-label" for="defaultCheck1">-->
                            <!--                                Kosongkan-->
                            <!--                            </label>-->
                            <!--                        </div>-->
                        </div>

                        <div class="bs-child">
                            <?php if(isset($value) && count($value->aksesori) > 0) :
                                foreach($value->aksesori as $aks) : ?>
                                    <div class="row mb-1 bscolor" id="bscolor-<?= $aks->id;?>">
                                        <div class="col-sm col-form-label"><?= $aks->nama;?></div>
                                        <div class="col-sm-auto">
                                            <button type="button" class="btn-sm btn-danger delbs" id="delbs-<?= $aks->id;?>">
                                                <i class="fas fa-trash-alt text-light"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="aksesori[]" value="<?= $aks->id;?>">
                                    </div>
                                <?php endforeach;?>
                            <?php endif;?>
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
                    <label for="jalur" class="col-lg-6 col-sm-12 col-form-label">Jalur Pengiriman <span class="text-danger">*</span></label>
                    <div class="col-lg-6 col-sm-12">
                        <select id="jalur" name="Jalur" class="form-control">
                            <option<?= ($Jalur == 'D') ? ' selected' : ''; ?> value="D">Darat
                            </option>
                            <option<?= ($Jalur == 'L') ? ' selected' : ''; ?> value="L">Laut
                            </option>
                            <option<?= ($Jalur == 'U') ? ' selected' : ''; ?> value="U">Udara
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4">  
                <div class="form-group row">
                    <label for="area" class="col-lg-5 col-sm-12 col-form-label">Area <span class="text-danger">*</span></label>
                    <div class="col-lg-7 col-sm-12">
                        <select id="area" name="Area" class="form-control">
                            <option value="">Pilih</option>
                            <?php foreach ($areakirim as $key => $a_k) :
                                $selected = $Area == $a_k->ID ? ' selected' : '';
                                ?>
                                <option<?= $selected;?> value="<?= $a_k->ID; ?>"><?= $a_k->Nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group row">
                    <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut <?php if( isset($estimasi) ) : ?><span class="text-danger">*</span><?php endif;?></label>
                    <div class="col-lg-4 col-sm-12">
                        <input value="<?= $Kapasitas; ?>" id="kapasitas" name="Kapasitas" type="number"
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
                    <?php if((isset($estimasi) || isset($copyprospek)) && $value->Lampiran1 == 1) : ?>
                    <a title="File <?= $FileLampiran1;?>" class="btn btn-sm file-link btn-success" href="<?= site_url('inputprospek/detail/' . $value->NoProspek . '/' . $value->Alt);?>" target="_blank"><i class="far fa-file"></i></a> &nbsp;
                    <input type="hidden" name="Lampiran1" value="<?= $Lampiran1;?>" />
                        <input type="hidden" name="FileLampiran1" value="<?= $FileLampiran1;?>" />
                    <?php endif;?>
                    <div class="custom-file">
                        <input readonly type="file" class="custom-file-input" id="inputGroupFile01"
                               aria-describedby="inputGroupFileAddon01" name="attachment">
                        <label class="custom-file-label" for="inputGroupFile01">Pilih file</label>
                    </div>&nbsp;
                    <button type="button" class="btn btn-sm btn-secondary reset-upload-form">Reset</button>
                    <?php if((isset($estimasi) || isset($copyprospek)) && $value->Lampiran1 == 1) : ?>
                    &nbsp;<button type="button" class="btn btn-sm btn-secondary delete-file">Hapus</button>
                    <?php endif;?>
                </div> 
            </div>
        </div>

<?php if( isset($estimasi) && isset($adhesive) && isset($prospek_tinta) ) : ?> 

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 22px">Kelengkapan Data</strong>
        </label>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="jml_up" class="col-lg-6 col-sm-12 col-form-label">Jumlah Up</label>
                <div class="col-lg-6 col-sm-12">
                    <input step="any" value="<?= $JumlahUp;?>" type="number" name="JumlahUp" class="form-control"
                           id="jml_up" />
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group row">
                <label for="lbr_film" class="col-lg-5 col-sm-12 col-form-label">Lebar Film</label>
                <div class="col-lg-7 col-sm-12">
                    <input step="any" value="<?= $LebarFilm;?>" type="number" name="LebarFilm" class="form-control"
                           id="lbr_film" />
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group row">
                <label for="<?= $form_satuan['form_name'];?>"
                       class="col-lg-5 col-sm-12 col-form-label"><?= $form_satuan['label'];?></label>
                <div class="col-lg-7 col-sm-12">
                    <input value="<?= (int)$value->{$form_satuan['form_name']};?>" type="number"
                           name="<?= $form_satuan['form_name'];?>" class="form-control dynamic-satuan-field"
                           id="<?= $form_satuan['form_name'];?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group row">
                <label for="adhesive" class="col-lg-6 col-sm-12 col-form-label">Adhesive <span class="text-danger">*</span></label>
                <div class="col-lg-6 col-sm-12">
                    <select id="adhesive" name="JenisAdhesive" class="form-control">
                        <option value="" <?= (!$value->JenisAdhesive) ? ' selected' : '';?>>Pilih</option>
                        <?php foreach ($adhesive as $ads) : ?>
                            <option<?= ($value->JenisAdhesive == $ads->id) ? ' selected' : '' ?> value="<?= $ads->id;?>">
                                <?= $ads->nama;?></option>
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
                        <th><button type="button" class="btn btn-sm btn-primary add-tnt"><i class="fas fa-plus-circle"></i></button></th>
                        <th style="width: 250px;">Warna Tinta</th>
                        <th>% Coverage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($prospek_tinta) > 0) :
                        $option_tinta = array_map(function ($item) {
                            return '<option value="'. $item->id .'">'. $item->nama .' - '. $item->merk .'</option>';
                        }, $tinta);

                        $generate_tinta_option = function ($tinta_id) use ($tinta) {
                            $option_tinta = array_map(function ($item) use ($tinta_id) {
                                $selected = ($item->id == $tinta_id) ? " selected" : "";
                                return '<option' . $selected . ' value="'. $item->id .'">'. $item->nama .' - '. $item->merk .'</option>';
                            }, $tinta);
                            return implode('', $option_tinta);
                        };
                        foreach ($prospek_tinta as $key => $pt) : ?>
                            <tr class="odd" data-key="<?= $key;?>">
                                <td>
                                    <button class="btn btn-sm btn-danger del-tinta" data-id="<?= $key;?>" type="button">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td>
                                    <select id="warnatinta" name="warnatinta[]" class="form-control">
                                        <?= $generate_tinta_option($pt->Tinta);?>
                                    </select>
                                </td>
                                <td>
                                    <input value="<?= (int)$pt->Coverage;?>" id="coverage" name="coverage[]" type="number"
                                           class="form-control">
                                </td>
                            </tr>
                        <?php endforeach;
                    else : ?>
                        <tr class="odd zero-record">
                            <td colspan="3">
                                <div class="text-center font-italic text-muted">Belum ada tinta</div>
                            </td>
                        </tr>
                    <?php endif;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php endif;?>

        <div class="row mt-4">
            <div class="col-12">
                <?= $submit_button;?>
            </div>
        </div>

    <?= $form_close;?>

    <!-- Modal -->
    <div class="modal fade" id="dbProduk" tabindex="-1" aria-labelledby="dbProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dbProdukLabel">Database Jenis Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="dataDbProduk" class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                        <tr>
                            <th>No</th> <!-- 1 -->
                            <th>Prospek</th> <!-- 2 -->
                            <th>Alt</th> <!-- 3 -->
                            <th>Nama Produk</th> <!-- 4 -->
                            <th>Material 1</th> <!-- 5 digabung jenis & tebal -->
                            <th>Material 2</th> <!-- 6 -->
                            <th>Material 3</th> <!-- 7 -->
                            <th>Material 4</th> <!-- 8 -->
                            <th>Tinta</th> <!-- 9 -->
                            <th>Tinta Khusus</th> <!-- 10 -->
                            <th>Adhesive</th> <!-- 11 -->
                            <th>Action</th> <!-- 12 buton utk copy value, close modal-->
                        </tr>
                        </thead>
                    </table>

                </div>
                <div class="modal-footer">
                    <button name="cancel" type="button" class="btn btn-link text-danger" data-dismiss="modal">Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAttachment" tabindex="-1" aria-labelledby="dbProdukLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dbProdukLabel">Attachment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button name="cancel" type="button" class="btn btn-link text-danger" data-dismiss="modal">Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>