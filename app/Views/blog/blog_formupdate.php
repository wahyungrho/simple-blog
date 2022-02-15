<?= $this->extend('home/main'); ?>

<?= $this->section('header'); ?>
<div class="col-sm-6">
    <h1>Ubah Artikel</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Post</a></li>
        <li class="breadcrumb-item active">Ubah Post</li>
    </ol>
</div>
<?= $this->endSection('header'); ?>

<?= $this->section('title'); ?>
<?= form_button('', '<i class="fa fa-backward" aria-hidden="true"></i> Kembali', [
    'class' => 'btn btn-warning btn-sm',
    'onclick' => 'location.href=("' . site_url('/post') . '")'
]); ?>
<?= $this->endSection('title'); ?>

<?= $this->section('content'); ?>
<?= form_open('/post/updatepost'); ?>
<?= session()->getFlashdata('errorpost'); ?>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Judul</label>
    <div class="col-sm-8">
        <input type="hidden" class="form-control" id="id" name="id" placeholder="Judul Artikel" autofocus value="<?= $id ?>">
        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Artikel" autofocus value="<?= $titles ?>">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label">Konten Artikel</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="content" name="content" placeholder="Konten Artikel" value="<?= $content; ?>">
    </div>
</div>
<div class="form-group row">
    <label for="" class="col-sm-4 col-form-label"></label>
    <div class="col-sm-4">
        <input type="submit" value="Simpan" class="btn btn-success">
    </div>
</div>
<?= form_close(); ?>
<?= $this->endSection('content'); ?>