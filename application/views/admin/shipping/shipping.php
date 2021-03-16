<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('shop_sender_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('shop_receiver_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMemberModal"> Add Shipping </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Shipping ID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php
                        foreach ($shipping as $s) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $sender_shipping[$index - 1]["sender"] ?></td>
                                <td><?= $s['name'] ?></td>
                                <td><?= $s['shipping_id'] ?></td>
                                <td><?php
                                    if ($s['status'] == 1) {
                                        echo "<span class='badge badge-sm badge-success'>Items sent.</span>";
                                    } else {
                                        echo "<span class='badge badge-sm badge-danger'>Items not sent.</span>";
                                    }
                                    ?></td>
                                <td><?= $s['created_at'] ?></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-primary btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>admin/viewshipping/<?= $s['id'] ?>" title="View"><i class="fa fa-eye"></i></a>
                                        </li>
                                        <?php
                                        if ($s['status'] == 0) {
                                        ?>
                                            <li class="list-inline-item">
                                                <a class="btn btn-success btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>admin/confirmshipping/<?= $s['id'] ?>" title="Confirm"><i class="fa fa-check"></i></a>
                                            </li>
                                        <?php } ?>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>admin/deleteshipping/<?= $s['id'] ?>" title="Delete"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add Shipping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/shipping'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shop_sender_id">From:</label>
                        <select id="shop_sender_id" name="shop_sender_id" class="form-control">
                            <?php foreach ($shops as $s) : ?>
                                <option value=<?= $s['id'] ?>><?= $s['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shop_receiver_id">To:</label>
                        <select id="shop_receiver_id" name="shop_receiver_id" class="form-control">
                            <?php foreach ($shops as $s) : ?>
                                <option value=<?= $s['id'] ?>><?= $s['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
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