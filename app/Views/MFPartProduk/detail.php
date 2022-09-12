<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

    <div class="msg_success"></div>


    <div class="dynamic-content">

        <div class="csc-form detail show">
            <div class="msg"></div>
            <div class="row">
                <div class="col-sm-2">No FGD</div>
                <div class="col-sm-4">
                    <input type="hidden" name="src_fgd" value="<?= $data->fgd;?>">
                    <div class="val"><?= $data->fgd;?></div>
                </div>
                <div class="col-sm-2">Revisi</div>
                <div class="col-sm-4">
                    <input type="hidden" name="src_revisi" value="<?= $data->revisi;?>">
                    <div class="val"><?= $data->revisi;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Nama Part Produk</div>
                <div class="col-sm-10">
                    <div class="val"><?= $data->nama;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Tujuan Penggunaan</div>
                <div class="col-sm-10">
                    <div class="val"><?= $data->tujuan_penggunaan;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Ukuran Jadi</div>
            </div>
            <div class="row">
                <div class="col-sm-2">P</div>
                <div class="col-sm-2">
                    <?= $data->panjang;?>
                </div>
                <div class="col-sm-2">L</div>
                <div class="col-sm-2">
                    <?= $data->lebar;?>
                </div>
                <div class="col-sm-2">T</div>
                <div class="col-sm-2">
                    <?= $data->tinggi;?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Kertas </div>
                <div class="col-sm-4">
                    <div class="val"><?= $jeniskertas;?></div>
                </div>
                <div class="col-sm-2">Flute </div>
                <div class="col-sm-4">
                    <div class="val"><?= $jenisflute;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Technical Draw </div>
                <div class="col-sm-2">
                    <div class="val"><?= $data->technical_draw;?></div>
                </div>
                <div class="col-sm-2">No Dokumen </div>
                <div class="col-sm-4">
                    <div class="val"><?= $data->no_dokumen;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Inner Pack </div>
                <div class="col-sm-4">
                    <div class="val"><?= $innerpack;?></div>
                </div>
                <div class="col-sm-2">Jumlah </div>
                <div class="col-sm-2">
                    <div class="val"><?= $data->jum_innerpack;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Outer Pack </div>
                <div class="col-sm-4">
                    <div class="val"><?= $outerpack;?></div>
                </div>
                <div class="col-sm-2">Jumlah </div>
                <div class="col-sm-2">
                    <div class="val"><?= $data->jum_outerpack;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Delivery Pack </div>
                <div class="col-sm-4">
                    <div class="val"><?= $deliverypack;?></div>
                </div>
                <div class="col-sm-4">Auto Packing Machine di Customer </div>
                <div class="col-sm-2">
                    <div class="val"><?= $data->auto_pack;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">Special Request </div>
                <div class="col-sm-10">
                    <div class="val"><?= $data->special_req;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">Dokumen Change Request </div>
                <div class="col-sm-3">
                    <div class="val"><?= $data->no_dokcr;?></div>
                </div>
                <label for="file_dokcr" class="col-sm-2 col-form-label">Dokumen </label>
                <div class="col-sm-4">
                    <div class="val">
                        <?php if($data->file_dokcr != null) : ?>
                            <a href="<?= site_url('mfpartproduk/dokcr/'.$id);?>" target="_blank">
                                <?= $data->file_dokcr;?>
                            </a>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        </div>

        <div class="container mt-4">
            <div class="row align-items-start mb-2">
                <div class="col text-left">
                    <h5>Sisi Part Produk</h5>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-primary open-sisi-form" data-nama="<?= $data->nama;?>">
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



    <!-- Modal -->
    <div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="sisi-form-modal">
                <input type="hidden" name="id_part" value="<?= $data->id;?>" />
                <input type="hidden" name="id" value="" />
                <div class="modal-content sisi-produk">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataFormLabel"><span class="heading-sisi-produk">Sisi Part Produk</span><span class="part-produk-title"><?= $data->nama;?></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="row">
                            <label for="fgd" class="col-sm-2 col-form-label">No FGD</span></label>
                            <div class="col-sm-4">
                                <!-- <input type="text" class="form-control" id="tfgd" name="tfgd" disabled><input type="hidden" class="form-control" id="fgd" name="fgd"> -->
                                <input value="<?= $data->fgd;?>" type="text" class="form-control" id="fgd" name="fgd" disabled>
                            </div>
                            <label for="trevisi" class="col-sm-2 col-form-label">Revisi</span></label>
                            <div class="col-sm-4">
                                <input value="<?= ($is_revision == 1) ? ($data->revisi + 1) : $data->revisi;?>" type="text" class="form-control" id="trevisi" name="trevisi" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label for="sisi" class="col-sm-2 col-form-label">Sisi</span></label>
                            <div class="col-sm">
                                <input type="text" class="form-control" id="sisi" name="sisi">
                            </div>
                            <label for="frontside" class="col-sm col-form-label">Frontside</span></label>
                            <div class="col-sm">
                                <input value="0" type="number" class="form-control" id="frontside" name="frontside">
                            </div>
                            <label for="backside" class="col-sm col-form-label">Backside</span></label>
                            <div class="col-sm">
                                <input value="0" type="number" class="form-control" id="backside" name="backside">
                            </div>
                        </div>
                        <div class="row">
                            <label for="special_req" class="col-sm-2 col-form-label">Special Requirement</span></label>
                            <div class="col-sm">
                                <textarea class="form-control" id="special_req" name="special_req"></textarea>
                            </div>

                        </div>

                        <div class="mt-2">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-warna-tab" data-toggle="tab" data-target="#nav-warna" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Warna</button>
                                    <button class="nav-link" id="nav-proses-tab" data-toggle="tab" data-target="#nav-proses" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Proses</button>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-warna" role="tabpanel" aria-labelledby="nav-warna-tab">

                                    <div class="row mt-2">
                                        <div class="col-sm-6">
                                            <!--                                            <form>-->
                                            <div class="form-group row">
                                                <label for="tinta" class="col-sm-2  col-form-label">Frontside</label>
                                                <div class="col-sm">
                                                    <select name="fscolors" class="form-control" id="tinta">
                                                        <option value="0" selected>-Pilih Warna-</option>
                                                        <?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
                                                            <option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-sm btn-primary add-fs">+</button>
                                                </div>
                                            </div>

                                            <!--                                            </form>-->
                                            <div class="fs-child"></div>

                                        </div>
                                        <div class="col-sm-6">
                                            <!--                                            <form>-->
                                            <div class="form-group row">
                                                <label for="tinta" class="col-sm-2  col-form-label">Backside</label>
                                                <div class="col-sm">
                                                    <select name="bscolors" class="form-control" id="tinta">
                                                        <option value="0" selected>-Pilih Warna-</option>
                                                        <?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
                                                            <option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-sm btn-primary add-bs">+</button>
                                                </div>
                                            </div>

                                            <!--                                            </form>-->
                                            <div class="bs-child"></div>

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-proses" role="tabpanel" aria-labelledby="nav-proses-tab">
                                    <div class="row mt-2">
                                        <div class="col-sm-4">
                                            <!--                                            <form>-->
                                            <label for="tinta" class="form-label">Proses Manual</label>
                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <select name="manualcolors" class="form-control" id="tinta">
                                                        <option value="0" selected>-Pilih Warna-</option>
                                                        <?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
                                                            <option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-sm btn-primary add-manual">+</button>
                                                </div>
                                            </div>

                                            <!--                                            </form>-->
                                            <div class="manual-child"></div>

                                        </div>
                                        <div class="col-sm-4">
                                            <!--                                            <form>-->
                                            <label for="tinta" class="form-label">Proses Finishing</label>
                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <select name="finishingcolors" class="form-control" id="tinta">
                                                        <option value="0" selected>-Pilih Warna-</option>
                                                        <?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
                                                            <option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-sm btn-primary add-finishing">+</button>
                                                </div>
                                            </div>

                                            <!--                                            </form>-->
                                            <div class="finishing-child"></div>
                                        </div>

                                        <div class="col-sm-4">
                                            <!--                                            <form>-->
                                            <label for="tinta" class="form-label">Proses Khusus</label>
                                            <div class="form-group row">
                                                <div class="col-sm">
                                                    <select name="khususcolors" class="form-control" id="tinta">
                                                        <option value="0" selected>-Pilih Warna-</option>
                                                        <?php foreach ($opsi_jenistinta as $key => $opsi_jenistinta_item) : ?>
                                                            <option value="<?= $opsi_jenistinta_item->id;?>"><?= $opsi_jenistinta_item->nama;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm">
                                                    <button type="button" class="btn btn-sm btn-primary add-khusus">+</button>
                                                </div>
                                            </div>

                                            <!--                                            </form>-->
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
                            <button name="submit" type="submit" class="btn btn-primary btn-save">Simpan</button>
                            <button name="cancel" type="button" class="btn btn-link btn-cancel text-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="dataDetail" tabindex="-1" aria-labelledby=dataDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="sisi-form-modal">
                <input type="hidden" name="id_part" value="<?= $data->id;?>" />
                <input type="hidden" name="id" value="" />
                <div class="modal-content sisi-produk">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataDetailLabel"><span class="heading-sisi-produk">Sisi Part Produk</span><span class="part-produk-title"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5">No FGD</div>
                            <div class="col-7">
                                <div class="sisi-view fgd"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Revisi</div>
                            <div class="col-7">
                                <div class="sisi-view revisi"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Sisi</div>
                            <div class="col-7">
                                <div class="sisi-view sisi"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Frontside</div>
                            <div class="col-7">
                                <div class="sisi-view frontside"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Backside</div>
                            <div class="col-7">
                                <div class="sisi-view backside"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Special Requirement</div>
                            <div class="col-7">
                                <div class="sisi-view special_req"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Aktif</div>
                            <div class="col-7">
                                <div class="sisi-view aktif"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Ditambahkan pada</div>
                            <div class="col-7">
                                <div class="sisi-view added"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Ditambahkan oleh</div>
                            <div class="col-7">
                                <div class="sisi-view added_by"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Warna</div>
                            <div class="col-7"></div>
                        </div>
                        <div class="row">
                            <div class="col-5"><div class="pl-4">Frontside</div></div>
                            <div class="col-7">
                                <div class="sisi-view fs-child"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5"><div class="pl-4">Backside</div></div>
                            <div class="col-7">
                                <div class="sisi-view bs-child"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">Proses</div>
                            <div class="col-7"></div>
                        </div>
                        <div class="row">
                            <div class="col-5"><div class="pl-4">Manual</div></div>
                            <div class="col-7">
                                <div class="sisi-view manual-child"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5"><div class="pl-4">Finishing</div></div>
                            <div class="col-7">
                                <div class="sisi-view finishing-child"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5"><div class="pl-4">Khusus</div></div>
                            <div class="col-7">
                                <div class="sisi-view khusus-child"></div>
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