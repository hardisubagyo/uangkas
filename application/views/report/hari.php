<!-- Begin Page Content -->


<?php

$this->load->helper('tglindo');
?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Harian</h6>
    </div>
    <div class="card-body">


        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Report Kas Harian</h3>
                    </div>


                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <form role="form" method="get" action="<?php echo site_url('Report/CariHari'); ?>">
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Tanggal</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="tanggal" class="form-control pull-right" id="datepicker">
                                            </div>
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