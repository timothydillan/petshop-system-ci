<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('start_date', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('end_date', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('shop_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>toko/groomresults" method="post">
        <div class="form-group">
            <!-- Date input -->
            <label for="birthday">Starting Date:</label>
            <input type="date" id="start_date" name="start_date">
        </div>
        <div class="form-group">
            <!-- Date input -->
            <label for="birthday">Ending Date:</label>
            <input type="date" id="end_date" name="end_date">
        </div>
        <button type="submit" class="btn btn-success">View</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>