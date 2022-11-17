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
                        <h5 class="modal-title" id=dataFormLabel">Tambah Modul</h5>
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

<?= $this->endSection();?>