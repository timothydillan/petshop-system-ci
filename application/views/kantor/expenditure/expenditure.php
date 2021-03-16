<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Shop Name</th>
                            <th>Description</th>
                            <th>Amount Requested</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php foreach ($expenditure as $e) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $e['name'] ?></td>
                                <td><?= $e['description'] ?></td>
                                <td>Rp. <?= number_format($e['amount_requested']) ?></td>
                                <td><?php
                                    if ($e['status'] == 1) {
                                        echo "<span class='badge badge-sm badge-success'>Accepted</span>";
                                    } else if ($e['status'] == 0) {
                                        echo "<span class='badge badge-sm badge-warning'>Waiting for Confirmation</span>";
                                    } else {
                                        echo "<span class='badge badge-sm badge-danger'>Rejected</span>";
                                    }
                                    ?></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>kantor/confirmexpenditure/<?= $e['id'] ?>" title="Confirm"><i class="fa fa-check"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>kantor/rejectexpenditure/<?= $e['id'] ?>" title="Reject"><i class="fa fa-times"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>