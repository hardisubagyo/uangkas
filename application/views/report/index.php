<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>

<div class="row">
    <div class="col-lg-4">

        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>

        <?= $this->session->flashdata('message'); ?>
        <div class="card border-success mb-3" style="max-width: 90rem;">
            <div class="card-header bg-success text-white">Cari Laporan</div>
            <div class="card-body text-primary">



                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-harian-tab" data-toggle="tab" href="#nav-harian" role="tab" aria-controls="nav-harian" aria-selected="true">Harian</a>
                        <a class="nav-item nav-link" id="nav-priode-tab" data-toggle="tab" href="#nav-priode" role="tab" aria-controls="nav-priode" aria-selected="false">Priode</a>
                        <a class="nav-item nav-link" id="nav-bulanan-tab" data-toggle="tab" href="#nav-bulanan" role="tab" aria-controls="nav-bulanan" aria-selected="false">Bulan</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-harian" role="tabpanel" aria-labelledby="nav-harian-tab">
                        <div class="col-md-12">
                            <form role="form" method="get" action="<?php echo site_url('Reportkantor/CariHari'); ?>">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanggal</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            </div>
                                            <!-- <input type="date" name="tanggal" class="form-control pull-right" id="datepicker"> -->
                                            <input type="text" name="tanggal" value="" id="tanggal" class="form-control pull-right" />
                                        </div>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-priode" role="tabpanel" aria-labelledby="nav-priode-tab">
                        <div class="col-md-12">
                            <form role="form" method="get" action="<?php echo site_url('Reportkantor/CariPeriode'); ?>">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Priode</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            </div>
                                            <input type="text" name="periode" value="" id="periode" class="form-control pull-right" />
                                        </div>


                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="nav-bulanan" role="tabpanel" aria-labelledby="nav-bulanan-tab">
                        <div class="col-md-12">
                            <form role="form" method="get" action="<?php echo site_url('Reportkantor/CariBulan'); ?>">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Bulan</label>
                                        <select class="form-control" name="bulan">
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tahun</label>
                                        <select class="form-control" name="tahun">
                                            <?php
                                            $now = date('Y');
                                            for ($a = 2018; $a <= $now; $a++) {
                                                echo "<option value='$a'>$a</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>

                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>



<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4'
    });
</script>

<script>
    $('#myTab a').on('click', function(e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>