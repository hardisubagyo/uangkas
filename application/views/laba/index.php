<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Presentase Laba</h6>
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

                <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#AddLaba"><i class="fas fa-plus"></i></a>
                <a href="<?php echo site_url('Laba/pdf'); ?>" class="btn btn-success mb-3"><i class="fas fa-file-pdf"></i></a>
                <a href="<?php echo site_url('Laba/excel'); ?>" class="btn btn-info mb-3"><i class="fas fa-file-excel"></i></a>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Total Presentase ZAI</th>
                                <th>Total Presentase ANDI</th>
                                <th>Total Presentase RASIT</th>
                                <th>Total Presentase Kantor</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($laba as $item){ ?>
                                <tr>
                                    <td><?php echo $item->tgl; ?></td>
                                    <td><?php echo number_format($item->total_zai,0,'.','.'); ?></td>
                                    <td><?php echo number_format($item->total_andi,0,'.','.'); ?></td>
                                    <td><?php echo number_format($item->total_rasit,0,'.','.'); ?></td>
                                    <td><?php echo number_format($item->total_kantor,0,'.','.'); ?></td>
                                    <td>
                                        <?php
                                            if($item->status == '0'){
                                                echo '<span class="badge badge-danger">Belum Masuk Kas</span>';
                                            }else{
                                                echo '<span class="badge badge-primary">Masuk Kas</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($item->status == '0'){ ?>
                                            <a href="<?php echo site_url('Laba/tras/'.$item->id_laba); ?>">
                                                <button type="button" class="btn btn-info btn-sm">Tras Kas</button>
                                            </a>
                                        <?php }else{ ?>
                                            <button type="button" class="btn btn-info btn-sm" style="cursor: no-drop;">Tras Kas</button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-success btn-sm">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm">Hapus</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="AddLaba" tabindex="-1" role="dialog" aria-labelledby="AddKasModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddSubmenuModal">Form Input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $(".add-row").click(function(){
                        var nama_customer = $("#nama_customer").val();
                        var no_invoice = $("#no_invoice").val();
                        var total_invoice = $("#total_invoice").val();
                        var keterangan = $("#keterangan").val();
                        var biaya_produksi = $("#biaya_produksi").val();
                        var zai = (2.5 / 100) * total_invoice;
                        var saldo_laba = total_invoice - zai - biaya_produksi;
                        var andi = (30 / 100) * saldo_laba;
                        var rasit = (30 / 100) * saldo_laba;
                        var kantor = saldo_laba - andi - rasit;

                        var markup = "<tr>\
                        <td><input type='text' class='form-control' name='nama_customer[]' readonly value='" + nama_customer + "'></td>\
                        <td><input type='text' class='form-control' name='no_invoice[]' readonly value='" + no_invoice + "'></td>\
                        <td><input type='text' class='form-control' name='total_invoice[]' readonly value='" + total_invoice + "'></td>\
                        <td><input type='text' class='form-control' name='keterangan[]' readonly value='" + keterangan + "'></td>\
                        <td><input type='text' class='form-control' name='zai[]' readonly value='" + zai + "'></td>\
                        <td><input type='text' class='form-control' name='biaya_produksi[]' readonly value='" + biaya_produksi + "'></td>\
                        <td><input type='text' class='form-control' name='saldo_laba[]' readonly value='" + saldo_laba + "'></td>\
                        <td><input type='text' class='form-control' name='andi[]' readonly value='" + andi + "'></td>\
                        <td><input type='text' class='form-control' name='rasit[]' readonly value='" + rasit + "'></td>\
                        <td><input type='text' class='form-control' name='kantor[]' readonly value='" + kantor + "'></td>\
                                    </tr>";
                        $("#form-body").append(markup);
                        $('#input-form ')[0].reset();

                        var all_total_invoice = document.getElementsByName('total_invoice[]');
                        var all_zai = document.getElementsByName('zai[]');
                        var all_saldo_laba = document.getElementsByName('saldo_laba[]');
                        var all_andi = document.getElementsByName('andi[]');
                        var all_rasit = document.getElementsByName('rasit[]');
                        var all_kantor = document.getElementsByName('kantor[]');

                        var tot_total_invoice = 0;
                        var tot_zai = 0;
                        var tot_saldo_laba = 0;
                        var tot_andi = 0;
                        var tot_rasit = 0;
                        var tot_kantor = 0;

                        for(var i=0;i<all_total_invoice.length;i++){
                            if(parseInt(all_total_invoice[i].value))
                                tot_total_invoice += parseInt(all_total_invoice[i].value);
                        }

                        for(var i=0;i<all_zai.length;i++){
                            if(parseInt(all_zai[i].value))
                                tot_zai += parseInt(all_zai[i].value);
                        }

                        for(var i=0;i<all_saldo_laba.length;i++){
                            if(parseInt(all_saldo_laba[i].value))
                                tot_saldo_laba += parseInt(all_saldo_laba[i].value);
                        }

                        for(var i=0;i<all_andi.length;i++){
                            if(parseInt(all_andi[i].value))
                                tot_andi += parseInt(all_andi[i].value);
                        }

                        for(var i=0;i<all_rasit.length;i++){
                            if(parseInt(all_rasit[i].value))
                                tot_rasit += parseInt(all_rasit[i].value);
                        }

                        for(var i=0;i<all_kantor.length;i++){
                            if(parseInt(all_kantor[i].value))
                                tot_kantor += parseInt(all_kantor[i].value);
                        }
                        
                        $('#total_invoice_all').val(tot_total_invoice);
                        $('#total_zai').val(tot_zai);
                        $('#total_saldo_laba').val(tot_saldo_laba);
                        $('#total_andi').val(tot_andi);
                        $('#total_rasit').val(tot_rasit);
                        $('#total_kantor').val(tot_kantor);
                        
                    });
                });    
            </script>
            <form class="form-inline" id="input-form">
                <center>
                    <input type="text" class="form-control" id="nama_customer" placeholder="Nama Customer"> 
                    <input type="text" class="form-control" id="no_invoice" placeholder="No Invoice"> 
                    <input type="text" class="form-control" id="total_invoice" placeholder="Total Invoice"> 
                    <input type="text" class="form-control" id="keterangan" placeholder="Keterangan"> 
                    <input type="text" class="form-control" id="biaya_produksi" placeholder="Biaya Produksi"> 
                    <button type="button" class="add-row btn btn-primary">Simpan</button>
                </center>
            </form>
            <form action="<?= base_url('laba/simpan'); ?>" method="post" id="list">
                <div class="modal-body">
                    <table class="table" id="forminput">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>No Invoice</th>
                                <th>Total Invoice</th>
                                <th>Keterangan</th>
                                <th>Zai (2,5%)</th>
                                <th>Biaya Produksi</th>
                                <th>Saldo Laba</th>
                                <th>Andi (30%)</th>
                                <th>Rasit (30%)</th>
                                <th>Kantor (40%)</th>
                            </tr>
                        </thead>
                        <tbody id="form-body"></tbody>
                        <tfoot id="t_foot">
                            <tr>
                                <th colspan="2">Total</th>
                                <th><input type="text" class="form-control" name="total_invoice_all" id="total_invoice_all" readonly></th>
                                <th>&nbsp;</th>
                                <th><input type="text" class="form-control" name="total_zai" id="total_zai" readonly></th>
                                <th>&nbsp;</th>
                                <th><input type="text" class="form-control" name="total_saldo_laba" id="total_saldo_laba" readonly></th>
                                <th><input type="text" class="form-control" name="total_andi" id="total_andi" readonly></th>
                                <th><input type="text" class="form-control" name="total_rasit" id="total_rasit" readonly></th>
                                <th><input type="text" class="form-control" name="total_kantor" id="total_kantor" readonly></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

</script>