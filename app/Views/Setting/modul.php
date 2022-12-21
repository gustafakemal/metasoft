<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

    <table id="dataList" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Modul</th>
            <th>Route</th>
            <th>Icon</th>
            <th>Group menu</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="">
                <input type="hidden" name="id" value="" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=dataFormLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-4 col-form-label">Nama Modul <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input name="nama_modul" type="text" class="form-control" id="nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="route" class="col-sm-4 col-form-label">Route <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input name="route" type="text" class="form-control" id="route">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-4 col-form-label">Icon Menu</label>
                            <div class="col-sm-8">
                                <input name="icon" type="text" class="form-control" id="icon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="parent" class="col-sm-4 col-form-label">Group/Parent</label>
                            <div class="col-sm-8">
                                <input name="group_menu" type="text" class="form-control" id="parent">
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
    <div class="modal fade" id="dataDetail" tabindex="-1" aria-labelledby="dataDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dataDetailLabel">Data Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">Nama Modul </div>
                        <div class="col-sm-8">
                            : <span class="nama_modul"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Route </div>
                        <div class="col-sm-8">
                            : <span class="route"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">Icon Menu</div>
                        <div class="col-sm-8">
                            : <span class="icon"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-3">Group/Parent</div>
                        <div class="col-sm-8">
                            : <span class="group_menu"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button name="cancel" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="usersModal" tabindex="-1" aria-labelledby="usersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="usersModalLabel">Set Akses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-2">Nama modul</div>
                        <div class="col-10">: <strong><span class="nama_modul"></span></strong></div>
                    </div>
                    <div class="row">
                        <div class="col-2">ID modul</div>
                        <div class="col-10">: <strong><span class="id_modul"></span></strong></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-2">Route</div>
                        <div class="col-10">: <code><span class="route code"></span></code></div>
                    </div>

                    <table id="dataUsers" class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>UserID</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Akses</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection();?>