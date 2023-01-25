<? // Form Input Prospek Metaflex ?>

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

<div class="prospek-view">

    <div class="row mb-2">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">No Prospek</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><strong><?= $data->NoProspek;?></strong></div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Alternatif</div>
                </div>
                <div class="col-lg-2 col-sm-12">
                    <div class="val"><strong><?= $data->Alt;?></strong></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-lg-2 col-sm-12">
            <div class="label">Nama Produk</div>
        </div>
        <div class="col-lg-10 col-sm-12">
            <div class="val"><?= $data->NamaProduk;?></div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Pemesan</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->NamaPemesan;?></div>
                </div>
            </div>
        </div>    
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Jenis Produk</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->NamaJenisProduk;?></div>
                </div>
            </div>
        </div>
    </div>

	<div class="row mb-1">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Segmen</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->NamaSegmen;?></div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Konten</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->NamaKonten;?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-lg-2 col-sm-12">
            <div class="label">Dimensi (mm)</div>
        </div>
        <div class="col-sm-10">
            <div class="val"><?= $data->Tebal;?> x <?= $data->Lebar;?> x <?= $data->Panjang;?> x <?= $data->Pitch;?></div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-lg-2 col-sm-12">
            <div class="label">Material</div>
        </div>
        <div class="col-sm-2">
            <div class="val">
                <div class="material-item">
                    <?php
                    $mat1 = $data->Material1;
                    $filtered1 = array_filter($materials, function ($item) use ($mat1) {
                        return $item->id == $mat1;
                    });
                    ?>
                    <div><?= $filtered1[0]->nama;?></div>
                    <span><?= $data->TebalMat1;?></span>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="material-item">
                <?php
                $mat2 = $data->Material2;
                $filtered2 = array_filter($materials, function ($item) use ($mat2) {
                    return $item->id == $mat2;
                });
                ?>
                <div><?= $filtered2[0]->nama;?></div>
                <span><?= $data->TebalMat2;?></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="material-item">
                <?php
                $mat3 = $data->Material3;
                $filtered3 = array_filter($materials, function ($item) use ($mat3) {
                    return $item->id == $mat3;
                });
                ?>
                <div><?= $filtered3[0]->nama;?></div>
                <span><?= $data->TebalMat3;?></span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="material-item">
                <?php
                $mat4 = $data->Material4;
                $filtered4 = array_filter($materials, function ($item) use ($mat4) {
                    return $item->id == $mat4;
                });
                ?>
                <div><?= $filtered4[0]->nama;?></div>
                <span><?= $data->TebalMat4;?></span>
            </div>
        </div>
    </div>

				
    <div class="row mb-1">
        <div class="col-4">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="label">Warna</div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="val"><?= $data->Warna;?></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-lg-3 col-sm-12">
                    <div class="label">Eyemark</div>
                </div>
                <div class="col-lg-9 col-sm-12">
                    <div class="val"><?= ($data->Eyemark == 1) ? 'Eyemark Only' : 'Eyemark & Block Color';?></div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="label">Roll Direction</div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="val"><?= ($data->RollDirection == 'Y') ? 'Terbaca' : 'Tidak Terbaca';?></div>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-2 col-sm-12">
            <div class="label">Catatan Produk</div>
        </div>
        <div class="col-lg-10 col-sm-12">
            <div class="val"><?= $data->Catatan;?></div>
        </div>
    </div>

	<div class="row mb-3 mt-4">
        <div class="col-lg-2 col-sm-12">
            <strong style="font-size: 16px">Finishing </strong>
        </div>
    </div>
            
    <div class="row mb-1">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Maksimal Join </div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->MaxJoin;?></div>
                </div>
            </div>
        </div>
		<div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Warna Tape</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->WarnaTape;?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Bag Making</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->NamaBagMaking;?></div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Bottom</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= $data->Bottom;?></div>
                </div>
            </div>
        </div>
    </div>
            
    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Open For Filling</div>
                </div>
                <div class="col-lg-8 col-sm-12">
                    <div class="val"><?= ($data->OpenForFilling == 'T') ? 'Top' : 'Bottom';?></div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="label">Aksesoris</div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm">
                            <?php
                                if(count($prospek_aksesori) > 0) :
                                    $pas = [];
                                    foreach($prospek_aksesori as $pa) :
                                        $pas[] = $pa->nama;
                                    endforeach;
                                    $aksesori = explode(', ', $pas);
                                else:
                                    $aksesori = '-';
                                endif;
                            ?>
                            <div class="val"><?= $aksesori;?></div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 mt-4">
        <div class="col-lg-2 col-sm-12">
            <strong style="font-size: 16px">Jumlah Order</strong>
        </div>
    </div>

	<Div class="row mb-1">
        <div class="col-4">
            <div class="row">
                <div class="col-6">
                    <div class="label">Jumlah </div>
                </div>
                <div class="col-6">
                    <div class="val"><?= $data->Jumlah;?> <?= ($data->Roll_Pcs == 'R') ? 'ROLL' : 'PCS';?></div>
				</div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="label">Toleransi (%)</div>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="val"><?= $data->Toleransi;?></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="label">Partial Qty</div>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="val"><?= ($data->Parsial == 'T') ? 'Tidak' : 'Ya';?></div>
                </div>
            </div>
        </div>
    </div>
            
    <div class="row">
        <div class="col-lg-2 col-sm-12">
            <div class="label">Keterangan</div>
        </div>
        <div class="col-lg-10 col-sm-12">
            <div class="val"><?= $data->Keterangan;?></div>
        </div>
    </div>

    <div class="row mb-3 mt-4">
        <div class="col-lg-2 col-sm-12">
            <strong style="font-size: 16px">Pengiriman</strong>
        </div>
    </div>
			
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="label">Jalur Pengiriman </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="val">
                    <?php if($data->Jalur == 'D') : ?>
                            Darat
                    <?php elseif($data->Jalur == 'D') : ?>
                            Laut
                    <?php else : ?>
                            Udara
                    <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="label">Area</div>
                </div>
                <div class="col-lg-7 col-sm-12">
                    <div class="val"><?= $data->NamaArea;?></div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="row">
                <div class="col-lg-5 col-sm-12">
                    <div class="label">Kapasitas Angkut</div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="val"><?= $data->Kapasitas;?></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>