<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('member_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('animal', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('race', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('price', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('description', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Member Name</th>
                            <th>Animal</th>
                            <th>Animal Race</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $earnings = 0;
                        foreach ($groom_results as $g) : ?>
                            <tr>
                                <td><?= $g['name'] ?></td>
                                <td><?= $g['animal'] ?></td>
                                <td><?= $g['race'] ?></td>
                                <td><?= $g['phone'] ?></td>
                                <td><?= $g['description'] ?></td>
                                <td>Rp. <?php $earnings += $g['price']; ?><?= number_format($g['price']) ?></td>
                                <td><?= $g['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?> </tbody>
                </table>
            </div>
            <h4>Total Earnings: <strong>Rp. <?= number_format($earnings) ?></strong></h4>
        </div>
    </div>
</div>