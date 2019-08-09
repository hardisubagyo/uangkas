</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright &copy; Your Website 2019</span>
    </div>
  </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Yakin and keluar?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Pilih "Logout" untuk mengakhiri</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap core JavaScript-->

<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
<script src=""></script>

<!-- datepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="<?php echo base_url(); ?>assets/temp/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script>
  // $('.custom-file-input').on('change', function() {
  //     let fileName = $(this).val().split('\\').pop();
  //     $(this).next(.
  //         'custom-file-label').addClass("selected").html(fileName);
  // });




  $(document).ready(function() {
    $('#datepicker').datepicker({
      format: "yyyy-mm-dd",
      autoclose: true
    });

    $('#reservation').daterangepicker({
      locale: {
        format: "YYYY/MM/DD"
      }
    })
  });


  $('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');

    $.ajax({
      url: "<?= base_url('admin/changeaccess'); ?>",
      type: 'post',
      data: {
        menuId: menuId,
        roleId: roleId
      },
      success: function() {
        document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
      }
    })
  });
</script>




<!-- date-range-picker -->

<script>
  $(document).ready(function() {
    $('#datepicker').datepicker({
      format: "yyyy-mm-dd",
      autoclose: true
    });

    $('#reservation').daterangepicker({
      locale: {
        format: "YYYY/MM/DD"
      }
    })
  });
</script>

<script>
  $(function() {
    $('#tanggal').daterangepicker({
      locale: {
        format: "YYYY/MM/DD"
      },
      singleDatePicker: true,
      showDropdowns: true
    }, function(start, end, label) {

    });
  });
  $(function() {
    $('#periode').daterangepicker({
      opens: 'left',
      locale: {
        format: "YYYY/MM/DD"
      }
    }, function(start, end, label) {
      //console.log("A new date selection was made: " + start.format('YYYY-dd-mm') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
</script>

</body>

</html>