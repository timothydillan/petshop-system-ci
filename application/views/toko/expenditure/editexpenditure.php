<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>toko/saveexpenditure/<?= $id ?>" method="post">
        <div class="form-group">
            <label for="name">Description:</label>
            <input type="text" class="form-control" id="description" name="description" placeholder="Name" value="<?= $description ?>">
        </div>
        <div class="form-group">
            <label for="name">Amount Requested (Rp.):</label>
            <input type="text" class="form-control mt-2" id="amount_requested" name="amount_requested" placeholder="Rp. .." value="<?= $amount_requested ?>">
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>