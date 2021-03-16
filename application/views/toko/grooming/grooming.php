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
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal"> Add Groom </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member Name</th>
                            <th>Animal</th>
                            <th>Animal Race</th>
                            <th>Phone</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Paid?</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php foreach ($groom as $g) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $g['name'] ?></td>
                                <td><?= $g['animal'] ?></td>
                                <td><?= $g['race'] ?></td>
                                <td><?= $g['phone'] ?></td>
                                <td><?= $g['description'] ?></td>
                                <td>Rp. <?= number_format($g['price']) ?></td>
                                <td><?php
                                    if ($g['paid'] == 1) {
                                        echo "<span class='badge badge-sm badge-success'>True</span>";
                                    } else {
                                        echo "<span class='badge badge-sm badge-danger'>False</span>";
                                    }
                                    ?></td>
                                <td><?= $g['created_at'] ?></td>
                                <td>
                                    <?php if ($g['id'] != 0) { ?>
                                        <!-- Call to action buttons -->
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a class="btn btn-success btn-sm btn-circle" type="button" title="Edit" href="<?= base_url() ?>toko/editgroom/<?= $g['id'] ?>"><i class="fa fa-edit"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a class="btn btn-danger btn-sm btn-circle" type="button" title="Delete" href="<?= base_url() ?>toko/deletegroom/<?= $g['id'] ?>"><i class="fa fa-trash"></i></a>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $index++; ?>
                        <?php endforeach; ?> </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Groom</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('toko/grooming'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="member_id">Member:</label>
                        <select id="member_id" name="member_id" class="fstdropdown-select form-control">
                            <?php foreach ($members as $m) : ?>
                                <option value=<?= $m['id'] ?>><?= $m['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="animal" name="animal" placeholder="Animal">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="race" name="race" placeholder="Animal Race">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="price" name="price" placeholder="Rp...">
                    </div>
                    <!--<p class="pl-1">Pay with: </p>
                    <div class="form-check form-check-inline pl-1">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Cash" selected>
                        <label class="form-check-label" for="inlineRadio1">Cash</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Debit">
                        <label class="form-check-label" for="inlineRadio2">Debit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Bon">
                        <label class="form-check-label" for="inlineRadio3">Bon</label>
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>