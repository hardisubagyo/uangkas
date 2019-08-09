<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Kas Keluar</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg">

                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <?= $this->session->flashdata('message'); ?>

                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#AddKasModal"><i class="fas fa-plus"></i></a>
                <a href="<?php echo site_url('Kantor/PdfKeluar'); ?>" class="btn btn-success mb-3"><i class="fas fa-file-pdf"></i></a>
                <a href="<?php echo site_url('Kantor/ExcelKeluar'); ?>" class="btn btn-info mb-3"><i class="fas fa-file-excel"></i></a>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">

                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col" width='100px'>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($kkeluar as $kk) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= date('d/m/Y', strtotime($kk['tanggal'])); ?></td>
                                    <td><?= $kk['keterangan']; ?></td>
                                    <td align="right"><?php echo number_format($kk['jumlah'], 0, ',', '.'); ?></td>

                                    <td>
                                        <a href="<?= base_url(); ?>kantor/editkaskeluar/<?= $kk['id']; ?>" class="badge badge-beige badge-success">Edit</a>
                                        <a href="<?= base_url(); ?>kantor/hapuskaskeluar/<?= $kk['id']; ?>" class="badge badge-beige badge-danger" onclick="return confirm('Yakin data dihapus ?');">Delete</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>

                    </table>
                </div>
            </div>
        </div>
    </div>




</div>





<!-- Modal Tambah Kas -->
<div class="modal fade" id="AddKasModal" tabindex="-1" role="dialog" aria-labelledby="AddKasModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddKasModal">Tambah Kas keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kantor/tambahkaskeluar'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="date" data-format="dd-MM-yyyy" class="form-control" id="tanggal" name="tanggal">
                        <small class="form-text text-danger"> <?= form_error('tanggal') ?></small>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan Pengeluaran">
                        <small class="form-text text-danger"> <?= form_error('keterangan') ?></small>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Pengeluarn">
                        <small class="form-text text-danger"> <?= form_error('jumlah') ?></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 
<script>
    $(document).ready(function() {
        $('#example').DataTable({
                "footerCallback": function(row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(2)
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        // Total over this page
                        pageTotal = api
                            .column(2), {
                                page: 'current'
                            })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(3).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            }
        });
    });
</script> -->