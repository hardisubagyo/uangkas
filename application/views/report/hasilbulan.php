<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="<?php echo site_url('Reportkantor/CariBulanPdf?bulan='.$this->input->get('bulan').'&tahun='.$this->input->get('tahun')); ?>" class="btn btn-success mb-3"><i class="fas fa-file-pdf"></i></a>
        <a href="<?php echo site_url('Reportkantor/CariBulanExcel?bulan='.$this->input->get('bulan').'&tahun='.$this->input->get('tahun')); ?>" class="btn btn-info mb-3"><i class="fas fa-file-excel"></i></a>
    </div>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Kas Kantor Bulan <?php echo $bulan . ' ' . $tahun; ?></h6>
    </div>
    <div class="card-body">
        <div class="card-body">
            <div class="row">
                <div class="col-lg">
                    <div class="row table-responsive">

                        <?php
                        $sisa_dana_hari = $total_pemasukan_bulan->Total - $total_pengeluaran_bulan->Total;
                        $sisa_dana = $total_pemasukan->Total - $total_pengeluaran->Total;
                        ?>

                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Total Pemasukan Keseluruhan</th>
                                    <th>Total Pengeluaran Keseluruhan</th>
                                    <th>Total Kas Keseluruhan</th>
                                    <th>Total Pemasukan <?php echo $bulan . ' ' . $tahun; ?></th>
                                    <th>Total Pengeluaran <?php echo $bulan . ' ' . $tahun; ?></th>
                                    <th>Total Sisa Kas <?php echo $bulan . ' ' . $tahun; ?></th>
                                </tr>
                                </tr>
                            </thead>
                            <tr>
                            <tr>
                                <td><?php echo number_format($total_pemasukan->Total, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($total_pengeluaran->Total, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($sisa_dana, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($total_pemasukan_bulan->Total, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($total_pengeluaran_bulan->Total, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($sisa_dana_hari, 0, ',', '.'); ?></td>
                            </tr>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Bulan <?php echo $bulan . ' ' . $tahun; ?></h6>
    </div>

    <div class="card-body">
        <div class="card-body">
            <div class="row">
                <div class="col-lg table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_pemasukan as $item) { ?>
                                <tr>
                                    <td><?php echo $item->keterangan; ?></td>
                                    <td><?php echo $item->tanggal; ?></td>
                                    <td><?php echo number_format($item->jumlah, 0, ',', '.'); ?></td>
                                    <td>Kas Masuk</td>
                                </tr>
                            <?php } ?>
                            <?php $no = 1;
                            foreach ($data_pengeluaran as $ros) { ?>
                                <tr>
                                    <td><?php echo $ros->keterangan; ?></td>
                                    <td><?php echo $ros->tanggal; ?></td>
                                    <td><?php echo number_format($ros->jumlah, 0, ',', '.'); ?></td>
                                    <td>Kas Keluar</td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"><b>Total Saldo</b></td>
                                <td colspan="2"><b><?php echo number_format($sisa_dana_hari, 0, ',', '.'); ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>