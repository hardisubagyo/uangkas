<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>

<div class="row">
    <div class="col-lg">

        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?= $this->session->flashdata('message'); ?>
        <div class="card border-success mb-3" style="max-width: 25rem;">
            <div class="card-header bg-success text-white">Edit Kas Keluar</div>
            <div class="card-body text-primary">
                <?= form_open_multipart('kantor/Rubahkaskeluar'); ?>
                <input type="hidden" name="id" value="<?= $kaskeluar['id']; ?>">
                <div class="form-group">
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $kaskeluar['tanggal'] ?>" placeholder="Tanggal Kas Masuk" required>
                    <small class="form-text text-danger"><?= form_error('tanggal') ?></small>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $kaskeluar['keterangan'] ?>" placeholder="Masukkan Keterangan" required>
                    </input>
                    <small class="form-text text-danger"><?= form_error('keterangan') ?></small>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $kaskeluar['jumlah'] ?>" placeholder="Masukkan jumlah kas masuk" required>
                </div>
                <button type="submit" name="edit" class="btn btn-outline-success">Update</button>
                <a href="<?= base_url('kantor/kaskeluar'); ?>" type="buttom" name="edit" class="btn btn-outline-danger align">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>