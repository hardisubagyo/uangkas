<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Bulanan</h6>
    </div>
    <div class="card-body">


        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Report Kas Bulanan</h3>
                    </div>


                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <form role="form" method="get" action="<?php echo site_url('Report/CariBulan'); ?>">
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
                                                <?php for ($x = 2000; $x < date('Y') + 2; $x++) { ?>
                                                    <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php } ?>
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
</div>