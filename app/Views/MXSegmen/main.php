<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<h3 class="page-title"><?= $page_title; ?></h3>

<?php if (session()->has('success')) : ?>
	<div class="alert alert-success"><?= session()->get('success'); ?></div>
<?php endif; ?>

<button type="button" class="btn btn-primary btn-add mr-2 add-data_btn" data-toggle="modal" data-target="#dataForm"> Tambah </button> 

<table id="dataList" class="table table-bordered table-striped" style="width: 100%">
	<thead>
		<tr>
			<th style="width: 25px;">No</th>
			<th class="sorting">Segmen</th>
			<th class="sorting">Aktif</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($record as $key => $value) : ?>
        <tr>
            <th scope="row"><?php echo $key+1; ?></th>
            <td><?php echo $value['Nama'] ?></td>
			<td><?php echo $value['Aktif'] ?></td>
            <td>
                <form action="<?php echo base_url('');?>" method="post" >
                <input type="hidden" name="id" value="<?php echo $value['ID'] ?>">
                <button type="submit" class="btn btn-success btn-sm">Edit</a>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<div class="modal fade" id="dataForm" tabindex="-1" aria-labelledby="dataFormLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<form action="<?php echo base_url('/mxsegmen/add');  ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="" />
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="dataFormLabel">Segmen Baru</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="msg"></div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="segmen">Segmen<span class="text-danger">*</span></label>
								<input name="segmen" type="text" class="form-control" id="segmen">
							</div>
							<div class="form-group">
								<label for="aktif">Status</label>
								<select name="aktif" class="form-control" id="aktif">
									<option value="Y">Aktif</option>
									<option value="T">Nonaktif</option>
								</select>
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

<?= $this->endSection() ?>