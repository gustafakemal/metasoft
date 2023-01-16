<? // Preview Hasil Estimasi Metaflex 
// Ada tab sebanyak variasi jumlah

// Halaman ini judulnya ->>  PERHITUNGAN HPP & HARGA JUAL (ESTIMASI HARGA)

?>

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

<?php //echo form_open('estimasipreview'); ?>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="no_prospek" class="col-lg-4 col-sm-12 col-form-label">NoProspek</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled type="text" class="form-control" id="no_prospek" value="" name="NoProspek">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="alt" class="col-lg-4 col-sm-12 col-form-label">Alternatif</label>
            <div class="col-lg-2 col-sm-12">
                <input value="" disabled type="number" class="form-control" id="alt" name="Alt">
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="namaproduk" class="col-lg-2 col-sm-12 col-form-label">Nama Produk</label>
    <div class="col-lg-10 col-sm-12">
        <input value="" disabled type="text" class="form-control" id="namaproduk" name="NamaProduk">
    </div>
</div>

<!-- Tab links -->
<div class="tab">
    <button class="tablinks"><strong>Jumlah Order</strong></button>
    <!-- Loop sebanyak alternatif jumlah -->
    <button class="tablinks" onclick="openTab(event, 500)"><!-- jumlah -->500</button>
    <button class="tablinks" onclick="openTab(event, 1000)"><!-- jumlah -->1000</button>
</div>


<!-- Loop sebanyak alternatif jumlah -->
<?php foreach ($jumlah_array as $key => $jml) : ?>
<div id="<?= $jml;?>" class="tabcontent">
    <div class="form-group row">
        <label class="col-lg-6 col-sm-12 col-form-label"><strong style="font-size: 20px">Hasil Kalkulasi Otomatis</strong></label>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 300px;">Jumlah Up</th>
                        <th style="width: 300px;">Lebar Film</th>
                        <th style="width: 300px;">Jumlah Pitch</th>
                        <th style="width: 300px;">Color Bar</th>
                        <th style="width: 300px;">Running Meter</th>
                        <th style="width: 300px;">Circum</th>
                        <th style="width: 300px;">Waste</th>
                        <th style="width: 300px;">Waste Persiapan</th>
                        <th style="width: 300px;">Jumlah Truk</th>
                    </tr>
                </thead>
                    <tr>
                        <td><?= $kalkulasi[$key]['Otomatis']['JumlahUp'];?></td>
                        <td><?= $kalkulasi[$key]['Otomatis']['LebarFilm'];?></td>
                        <td><?= $kalkulasi[$key]['Otomatis']['JumlahPitch'];?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Film</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Layer</th>
                            <th style="width: 300px;">Film</th>
                            <th style="width: 150px;">Tebal</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Tinta</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Tinta</th>
                            <th style="width: 150px;">Coverage</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-5 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Solvent</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Jenis</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Adhesive</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Jenis</th>
                            <th style="width: 150px;">Luasan(PxL)</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Biaya Lain-lain</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Nama</th>
                            <th style="width: 150px;">Keterangan</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Harga Jual</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Biaya Material</th>
                            <th style="width: 300px;">Biaya/Pcs/Roll</th>
                            <th style="width: 300px;">Harga Manager</th>
                            <th style="width: 300px;">Harga Senior</th>
                            <th style="width: 300px;">Harga Junior</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- akhir dari yg dilooping -->

<!-- Loop sebanyak alternatif jumlah -->
<div id="1000" class="tabcontent">
    <div class="form-group row">
        <label class="col-lg-6 col-sm-12 col-form-label"><strong style="font-size: 20px">Hasil Kalkulasi Otomatis</strong></label>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th style="width: 300px;">Jumlah Up</th>
                        <th style="width: 300px;">Lebar Film</th>
                        <th style="width: 300px;">Jumlah Pitch</th>
                        <th style="width: 300px;">Color Bar</th>
                        <th style="width: 300px;">Running Meter</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td> 
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>   
                        <th style="width: 300px;">Circum</th>
                        <th style="width: 300px;">Waste</th>
                        <th style="width: 300px;">Waste Persiapan</th>
                        <th style="width: 300px;">Jumlah Truk</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Film</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Layer</th>
                            <th style="width: 300px;">Film</th>
                            <th style="width: 150px;">Tebal</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Tinta</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Tinta</th>
                            <th style="width: 150px;">Coverage</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-5 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Solvent</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Jenis</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Pemakaian Adhesive</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Jenis</th>
                            <th style="width: 150px;">Luasan(PxL)</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum pemakaian --></td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Biaya Lain-lain</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;"></th>
                            <th style="width: 300px;">Nama</th>
                            <th style="width: 150px;">Keterangan</th>
                            <th style="width: 250px;">Harga</th>
                            <th style="width: 250px;">Pemakaian</th>
                            <th style="width: 250px;">Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="odd tot">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>TOTAL</td>
                            <td><!-- sum biaya --></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-lg-4 col-sm-12 col-form-label"><strong style="font-size: 20px">Harga Jual</strong></label>
    </div>

    <div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 300px;">Biaya Material</th>
                            <th style="width: 300px;">Biaya/Pcs/Roll</th>
                            <th style="width: 300px;">Harga Manager</th>
                            <th style="width: 300px;">Harga Senior</th>
                            <th style="width: 300px;">Harga Junior</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<?php endforeach;?>
<!-- akhir dari yg dilooping -->



<br>
<div class="row">
    <div class="col-1">
        <button type="button" class="btn btn-primary">Kembali</button>
    </div>
    <div class="col-1">
        <button type="button" class="btn btn-primary">Simpan</button>
    </div>
</div>


<?=$this->endSection()?>