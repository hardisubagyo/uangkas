<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $tittle; ?></h1>

<div class="row">
    <div class="col-lg-6">

        <?= $this->session->flashdata('message'); ?>

        <form method="post" action="<?= base_url('user/changepass'); ?>">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password">
                <?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
                <?= form_error('new_password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label for="repeat_password">Repeat Password</label>
                <input type="password" class="form-control" id="repeat_password" name="repeat_password">
                <?= form_error('repeat_password', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</div>