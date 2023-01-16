<? // Antrian Permintaan Estimasi
// Dilihat oleh Estimator : Berisi list semua prospek yg minta estimasi, dan estimasinya belum dikerjakan

?>

<?= $this->extend('theme') ?>

<?= $this->section('title') ?>
<?= $page_title; ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

    <h3 class="page-title"><?= $page_title; ?></h3>

<p>Jumlah Up</p>
<p>Lebar film</p>

    <p>Jumlah Pitch</p>
    <p>Color Bar</p>
    <p>Circum</p>
    <p>Running Meter</p>
    <p>Waste</p>
    <p>Waste Persiapan</p>
    <p>Jumlah Truk</p>

<?= $this->endSection() ?>