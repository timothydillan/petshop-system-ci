<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('description', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('amount_requested', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addExpenditureModal"> Request </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
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
                                            <a class="btn btn-success btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>toko/editexpenditure/<?= $e['id'] ?>" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>toko/deleteexpenditure/<?= $e['id'] ?>" title="Delete"><i class="fa fa-trash"></i></a>
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

<!-- Add Modal -->
<div class="modal fade" id="addExpenditureModal" tabindex="-1" role="dialog" aria-labelledby="addExpenditureModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenditureModalLabel">Request Expenditure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('toko/expenditurerequest'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control mt-2" id="amount_requested" name="amount_requested" placeholder="Rp. ....">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>