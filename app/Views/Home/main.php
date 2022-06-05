<?= $this->extend('theme')?>

<?= $this->section('title')?>
<?= $page_title;?>
<?= $this->endSection();?>

<?= $this->section('content')?>

<div class="page-title-wrapper">
    <h3 class="page-title"><?= $page_title;?></h3>
</div>

<div class="row">
	<div class="col-lg-12 col-sm-12">
		
		<table id="customerList" class="table table-bordered table-striped" style="width: 100%">
			<thead>
				<tr>
					<th style="width: 25px;">No</th>
					<th>Tanggal dibuat</th>
					<th>Nama Pemesan</th>
					<th>Contact person</th>
					<th>Wajib pajak</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
		</table>

	</div>
</div>


<?= $this->endSection()?>