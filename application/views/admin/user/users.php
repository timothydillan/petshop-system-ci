<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('role_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('password', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal"> Add User </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php foreach ($users as $u) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $u['name'] ?></td>
                                <td><?= $u['email'] ?></td>
                                <td>
                                    <?php
                                    if ($u['role_id'] == 1) {
                                        echo "Admin";
                                    } else if ($u['role_id'] == 2) {
                                        echo "Kantor";
                                    } else {
                                        echo "Toko";
                                    }
                                    ?></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>admin/edituser/<?= $u['id'] ?>" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>admin/deleteuser/<?= $u['id'] ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                        </li>
                                    </ul>
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
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="role_id">Choose a Role:</label>
                        <select id="role_id" name="role_id" class="form-control">
                            <option value=1>Admin/Master</option>
                            <option value=2>Kantor</option>
                            <option value=3>Toko</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
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