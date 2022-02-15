<?= $this->extend('home/main'); ?>

<?= $this->section('header'); ?>
<div class="col-sm-6">
    <h1>Beranda</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">Beranda</li>
    </ol>
</div>
<?= $this->endSection('header'); ?>

<?= $this->section('title'); ?>
Kumpulan blog terbaru
<?= $this->endSection('title'); ?>

<?= $this->section('content'); ?>
<?php

foreach ($datapost as $data) : ?>
    <div class="col-12 col-sm-6 col-md-4 ">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">

            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-12">
                        <h2 class="lead"><b><?= $data['title']; ?></b></h2>
                        <p class="text-muted text-sm"><?= $data['content']; ?></p>
                        <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"></span> <?= $data['username']; ?></li>
                            <li class="small"><span class="fa-li"></span><?= $data['date']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php endforeach

?>
<?= $this->endSection('content'); ?>