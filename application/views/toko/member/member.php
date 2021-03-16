<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('phone', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('address', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMemberModal"> Add Member </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php foreach ($members as $m) : ?>
                            <tr>
                                <td><?= $index ?></td>
                                <td><?= $m['name'] ?></td>
                                <td><?= $m['phone'] ?></td>
                                <td><?= $m['address'] ?></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>toko/editmember/<?= $m['id'] ?>" title="Edit"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" data-placement="top" href="<?= base_url() ?>toko/deletemember/<?= $m['id'] ?>" title="Delete"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('toko/member'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Member Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
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