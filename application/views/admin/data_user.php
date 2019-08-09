<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>

<div class="row">
    <div class="col-lg">


        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

        <?= $this->session->flashdata('message'); ?>

        <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#AddKasKeluarModal">Add Kas Kantor</a>

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tgl Registrasi</th>
                    <th scope="col">Aktif</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Action</th>


                </tr>
            </thead>
            <tbody>

                <?php $i = 1; ?>
                <?php foreach ($users as $us) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $us['name']; ?></td>
                        <td><?= $us['email']; ?></td>
                        <td><?= date('d F Y', $user['date_created']); ?></td>
                        <td><?= $us['is_active']; ?></td>
                        <td>
                            <img src="<?php echo base_url('assets/img/profile/' . $us['image']) ?>" class="img img-responsive" width="60">
                        </td>
                        <td>

                            <a href="" class="badge badge-pill badge-success">Edit</a>
                            <a href="" class="badge badge-pill badge-danger">Delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>