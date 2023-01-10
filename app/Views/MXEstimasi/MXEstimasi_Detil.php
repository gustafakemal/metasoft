<? // Detil Hasil Estimasi Metaflex 

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

<?php echo form_open('estimasidetil'); ?>

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

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="pemesan" class="col-lg-4 col-sm-12 col-form-label">Pemesan</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled id="pemesan" name="Pemesan" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="jenisproduk" class="col-lg-4 col-sm-12 col-form-label">Jenis Produk</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled id="jenisproduk" name="JenisProduk" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="segmen" class="col-lg-4 col-sm-12 col-form-label">Segmen</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled id="segmen" name="Segmen" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="konten" class="col-lg-4 col-sm-12 col-form-label">Konten</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled id="konten" name="Konten" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label">Dimensi (mm)</label>
    <div class="col-sm-2">
        <input value="" disabled class="form-control" id="tebal" name="Tebal">
    </div>
    <div class="col-sm-2">
        <input value="" disabled class="form-control" id="panjang" name="Panjang">
    </div>
    <div class="col-sm-2">
        <input value="" disabled class="form-control" id="lebar" name="Lebar">
    </div>
    <div class="col-sm-2">
        <input value="" disabled class="form-control" id="pitch" name="Pitch">
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Finishing </strong> </label>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="hasil" class="col-lg-6 col-sm-12 col-form-label">Bentuk Hasil</label>
            <div class="col-lg-6 col-sm-12">
                <input value="" disabled class="form-control" id="rollpcs" name="rollpcs">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <label for="finishing" class="col-lg-5 col-sm-12 col-form-label">Finishing </label>
            <div class="col-lg-7 col-sm-12">
                <input value="" disabled class="form-control" id="finishing" name="finishing">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <!-- label Center Seal dan isikolom ketfinishing tergantung dari jenis finishing -->
            <label for="ketfinishing" class="col-lg-5 col-sm-12 col-form-label">Center Seal</label>
            <div class="col-lg-4 col-sm-12">
                <input value="" disabled class="form-control" id="ketfinishing" name="ketfinishing">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="row">
            <label for="maxjoin" class="col-lg-4 col-sm-12 col-form-label">Maksimal Join</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled class="form-control" id="maxjoin" name="MaxJoin">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="warnatape" class="col-lg-4 col-sm-12 col-form-label">Warna Tape</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled class="form-control" id="warnatape" name="WarnaTape">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="bagmaking" class="col-lg-4 col-sm-12 col-form-label">Bag Making</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled class="form-control" id="bagmaking" name="BagMaking">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="bottom" class="col-lg-4 col-sm-12 col-form-label">Bottom</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled class="form-control" id="bottom" name="Bottom">
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="form-group row">
            <label for="filling" class="col-lg-4 col-sm-12 col-form-label">Open For Filling</label>
            <div class="col-lg-8 col-sm-12">
                <input value="" disabled class="form-control" id="filling" name="OpenForFilling">
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group row">
            <label for="aksesoris" class="col-lg-4 col-sm-12 col-form-label">Aksesoris</label>
            <div class="col-sm-6">
                <input value="" disabled class="form-control" id="aksesoris" name="aksesoris">
                <!-- jika banyak pakai koma -->
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Jumlah</strong> </label>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="jumlah" class="col-6">Jumlah </label>
            <div class="col-6">
                <input value="" disabled id="jumlah" name="Jumlah" class="form-control">
                <!-- jika banyak pakai koma -->
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group row">
            <label for="toleransi" class="col-lg-7 col-sm-12 col-form-label">Toleransi (%)</label>
            <div class="col-lg-5 col-sm-12">
                <input value="" disabled id="toleransi" name="Toleransi" type="number" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group row">
            <label for="parsial" class="col-lg-6 col-sm-12 col-form-label">Partial Qty</label>
            <div class="col-lg-6 col-sm-12">
                <input value="" disabled id="parsial" name="Parsial" class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-form-label"><strong style="font-size: 16px">Pengiriman</strong></label>
</div>

<div class="row">
    <div class="col-4">
        <div class="form-group row">
            <label for="jalur" class="col-lg-6 col-sm-12 col-form-label">Jalur Pengiriman
            </label>
            <div class="col-lg-6 col-sm-12">
                <input value="" disabled id="jalur" name="Jalur" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <label for="area" class="col-lg-5 col-sm-12 col-form-label">Area</label>
            <div class="col-lg-7 col-sm-12">
                <input value="" disabled id="area" name="Area" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <label for="kapasitas" class="col-lg-5 col-sm-12 col-form-label">Kapasitas Angkut</label>
            <div class="col-lg-4 col-sm-12">
                <input value="" disabled id="kapasitas" name="Kapasitas" type="number" class="form-control">
            </div>
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
                    <tr>
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
                    <tr>
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
                    <tr class="odd">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
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
                    <tr class="odd">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="odd">
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
                        <th style="width: 300px;">Jumlah</th>
                        <th style="width: 300px;">Biaya Material</th>
                        <th style="width: 300px;">Biaya/Pcs/Roll</th>
                        <th style="width: 300px;">Harga Manager</th>
                        <th style="width: 300px;">Harga Senior</th>
                        <th style="width: 300px;">Harga Junior</th>
                        <th style="width: 300px;">Harga Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- looping sesuai alt jumlah -->
                    <tr class="odd">
                        <td><!-- jumlah --></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><input id="hargajual" name="hargajual" type="number" class="form-control"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Simpan</button>
    </div>
</div>

</form>
</div>

<?=$this->endSection()?>