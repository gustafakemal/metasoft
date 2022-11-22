<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

    <table id="dataAccessRight" class="table table-bordered table-striped" style="width: 100%">
        <thead>
        <tr>
            <th>No</th>
            <th>UserID</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalUserAccess" tabindex="-1" aria-labelledby=dataFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form name="">
                <input type="hidden" name="id" value="" />
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id=dataFormLabel">Hak akses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-4">
                            <div class="col-2">
                                UserID
                            </div>
                            <div class="col-10">
                                : <strong><span class="uid"></span></strong>
                            </div>
                            <div class="col-2">
                                Nama
                            </div>
                            <div class="col-10">
                                : <strong><span class="nama_peg"></span></strong>
                            </div>
                        </div>

                        <div class="tbl-modul">

                        <table id="modulPriv" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Modul</th>
                                <th>R</th>
                                <th>R/W</th>
                                <th>R/W/D</th>
                            </tr>
                            </thead>
                        </table>

                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

<?= $this->endSection();?>