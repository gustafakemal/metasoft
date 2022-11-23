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


    <div class="dynamic-content">


        <?php //echo form_open_multipart('MFPartProduk/apiAddProcess');?>
        <form name="partproduct-form" class="csc-form show">
            <div class="msg"></div>
            <input type="hidden" name="ref" value="<?= ($ref != null) ? $ref : '';?>" />
            <input type="hidden" name="id_produk" value="<?= ($id_produk != null) ? $id_produk : '';?>" />
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="fgd" class="col-lg-4 col-sm-12 col-form-label">No FGD</span></label>
                        <div class="col-lg-8 col-sm-12">
                            <!-- <input type="text" class="form-control" id="tfgd" name="tfgd" disabled><input type="hidden" class="form-control" id="fgd" name="fgd"> -->
                            <input type="text" class="form-control" id="fgd" name="fgd" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="trevisi" class="col-lg-4 col-sm-12 col-form-label">Revisi</span></label>
                        <div class="col-lg-8 col-sm-12">
                            <input type="text" class="form-control" id="trevisi" name="trevisi" disabled><input type="hidden" class="form-control" id="revisi" name="revisi">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="nama_produk" class="col-lg-2 col-sm-12 col-form-label">Nama Part Produk <span class="text-danger">*</span></label>
                <div class="col-lg-10 col-sm-12">
                    <input type="text" class="form-control" id="nama_produk" name="nama" style="text-transform: uppercase">
                </div>
            </div>
            <div class="form-group row">
                <label for="tujuan_penggunaan" class="col-lg-2 col-sm-12 col-form-label">Tujuan Penggunaan <span class="text-danger">*</span></label>
                <div class="col-lg-10 col-sm-12">
                    <input type="text" class="form-control" id="tujuan_penggunaan" name="tujuan_penggunaan">
                </div>
            </div>
            <div class="form-group row">
                <label for="panjang" class="col-lg-2 col-sm-12 col-form-label">Ukuran Jadi (mm)<span class="text-danger">*</span></label>
                <div class="col-sm-4">
                    <input type="number" class="form-control" id="panjang" name="panjang"  placeholder="Panjang">
                </div>
                <div class="col-lg-3 col-sm-4">
                    <input type="number" class="form-control" id="lebar" name="lebar"  placeholder="Lebar">
                </div>
                <div class="col-lg-3 col-sm-4">
                    <input type="number" class="form-control" id="tinggi" name="tinggi"  placeholder="Tinggi">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="kertas" class="col-lg-4 col-sm-12 col-form-label">Kertas </label>
                        <div class="col-lg-8 col-sm-12">
                            <select name="kertas" class="form-control" id="kertas">
                                <option value="0" selected>Pilih Jenis Kertas</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="flute" class="col-lg-4 col-sm-12 col-form-label">Flute </label>
                        <div class="col-lg-8 col-sm-12">
                            <select name="flute" class="form-control" id="flute">
                                <option value="0" selected>Pilih Jenis Flute</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group row">
                        <label for="metalize" class="col-lg-6 col-sm-12 col-form-label">Metalize </label>
                        <div class="col-lg-6 col-sm-12">
                            <select name="metalize" id="metalize" class="form-control">
                                <option value="Y">Ya</option>
                                <option value="T" selected>Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group row">
                        <label for="technical_draw" class="col-lg-5 col-sm-12 col-form-label">Technical Draw </label>
                        <div class="col-lg-7 col-sm-12">
                            <select name="technical_draw" id="technical_draw" class="form-control">
                                <option value="Y">Ya</option>
                                <option value="T" selected>Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group row">
                        <label for="no_dokumen" class="col-lg-4 col-sm-12 col-form-label">No Dokumen <span class="no-dok-mark d-none text-danger">*</span></label>
                        <div class="col-lg-8 col-sm-12">
                            <input type="text" class="form-control" id="no_dokumen" name="no_dokumen" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="inner_pack" class="col-lg-4 col-sm-12 col-form-label">Inner Pack </label>
                        <div class="col-lg-8 col-sm-12">
                            <select name="inner_pack" class="form-control" id="inner_pack">
                                <option value="0" selected>Pilih Jenis Inner Pack</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <label for="jum_innerpack" class="col-lg-4 col-sm-12 col-form-label">Jumlah </label>
                        <div class="col-lg-8 col-sm-12">
                            <input type="number" class="form-control" id="jum_innerpack" name="jum_innerpack"  value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="outer_pack" class="col-lg-4 col-sm-12 col-form-label">Outer Pack </label>
                        <div class="col-lg-8 col-sm-12">
                            <select name="outer_pack" class="form-control" id="outer_pack">
                                <option value="0" selected>Pilih Jenis Outer Pack</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="jum_outerpack" class="col-lg-4 col-sm-12 col-form-label">Jumlah </label>
                        <div class="col-lg-8 col-sm-12">
                            <input type="number" class="form-control" id="jum_outerpack" name="jum_outerpack"  value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <label for="deliver_pack" class="col-lg-4 col-sm-12 col-form-label">Delivery Pack </label>
                        <div class="col-lg-8 col-sm-12">
                            <select name="deliver_pack" class="form-control" id="deliver_pack">
                                <option value="0" selected>Pilih Jenis Delivery Pack</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label for="auto_pack" class="col-lg-8 col-sm-12 col-form-label">Auto Packing Machine di Customer </label>
                        <div class="col-lg-4 col-sm-12">
                            <select name="auto_pack" id="auto_pack" class="form-control">
                                <option value="Y">Ya</option>
                                <option value="T" selected>Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="special_req" class="col-lg-2 col-sm-12 col-form-label">Special Request </label>
                <div class="col-lg-10 col-sm-12">
                    <textarea name="special_req" class="form-control" id="special_req"></textarea>

                </div>
            </div>
<!--            <div class="form-group row">-->
<!---->
<!--                <label for="no_dokcr" class="col-sm-3 col-form-label">Dokumen Change Request </label>-->
<!--                <div class="col-sm-3">-->
<!--                    <input type="text" class="form-control" id="no_dokcr" name="no_dokcr">-->
<!--                </div>-->
<!--                <label for="file_dokcr" class="col-sm-2 col-form-label">Upload Dokumen <span class="tooltip-icon" data-toggle="tooltip" title="Ukuran max 500Kb, harus berformat .pdf atau .jpg."><i class="fas fa-question-circle"></i></span></label>-->
<!--                <div class="col-sm-4">-->
<!--                    <input type="file" class="form-control" id="file_dokcr" name="file_dokcr">-->
<!--                </div>-->
<!--            </div>-->





            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>


        </form>

        <div class="container mt-4">
            <div class="row align-items-start mb-2">
                <div class="col text-left">
                    <h5>Sisi Part Produk</h5>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-primary" disabled>
                        Tambah Sisi
                    </button>
                </div>
            </div>

        </div>
        <div class="tbl-data-sisipartproduct">
            <table id="dataList" class="table table-bordered table-striped" style="width: 100%;">

                <thead>
                <tr>
                    <th>Sisi</th>
                    <th>Warna<br>Frontside</th>
                    <th>Warna<br>Backside</th>
                    <th>Special Requirements</th>
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

<?= $this->endSection() ?>