<?= $this->extend('home/main'); ?>

<?= $this->section('header'); ?>
<div class="col-sm-6">
    <h1>Post Blog</h1>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">Post</li>
    </ol>
</div>
<?= $this->endSection('header'); ?>

<?= $this->section('title'); ?>
<div class="panel-heading">
    <?= form_button('', '<i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data', [
        'class'     => 'btn btn-sm btn-primary',
        'onclick'   => 'location.href=("' . base_url('post/formadd') . '")'
    ]); ?>
</div>
<?= $this->endSection('title'); ?>

<?= $this->section('content'); ?>
<?= session()->getFlashdata('successpost'); ?>
<div class="responsive">
    <table class="table" id="tbpost">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kontent</th>
                <th>Dibuat pada</th>
                <th>Author</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            foreach ($datapost as $data) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['title']; ?></td>
                    <td><?= $data['content']; ?></td>
                    <td><?= $data['date']; ?></td>
                    <td><?= $data['username']; ?></td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" title="Edit Data" onclick="edit('<?= $data['idpost']; ?>')">
                            <i class="fa fa-edit fa-sm"></i>
                        </button>

                        <form action="/post/delete/<?= $data['idpost']; ?>" method="POST" style="display: inline;" onsubmit="var r = confirm('Apakah kamu yakin menghapus data tersebut ?'); if (r == true){return true;} else {event.preventDefault; return false;}">
                            <!-- <input type="hidden" value="DELETE" name="__method"> -->

                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                <i class="fa fa-trash-alt fa-sm"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach
            ?>
        </tbody>
    </table>
</div>
<script>
    function edit(id) {
        window.location = ('/post/formupdate/' + id);
    }
</script>
<?= $this->endSection('content'); ?>