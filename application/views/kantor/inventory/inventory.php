<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= form_error('shop_name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('item_barcode', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('item_name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('item_brand', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
    <?= form_error('item_amount', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal"> Add Item </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Barcode</th>
                            <th>Item Name</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inv as $i) : ?>
                            <tr>
                                <td><?= $i['shop_name'] ?></td>
                                <td><?= $i['item_barcode'] ?></td>
                                <td><?= $i['item_name'] ?></td>
                                <td><?= $i['item_brand'] ?></td>
                                <td><?= $i['item_type'] ?></td>
                                <td><?= $i['item_amount'] ?></td>
                                <td>
                                    <!-- Call to action buttons -->
                                    <ul class="list-inline m-0">
                                        <li class="list-inline-item">
                                            <a class="btn btn-success btn-sm btn-circle" type="button" title="Edit" href="<?= base_url() ?>kantor/editinventory/<?= $i['id'] ?>"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="btn btn-danger btn-sm btn-circle" type="button" title="Delete" href="<?= base_url() ?>kantor/deleteinventory/<?= $i['id'] ?>"><i class="fa fa-trash"></i></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
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
                <h5 class="modal-title" id="addUserModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('kantor/inventory'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shop_id">Shop:</label>
                        <select id="shop_id" name="shop_id" class="fstdropdown-select form-control">
                            <?php foreach ($users as $u) : if ($u['role_id'] != 3) continue; ?>
                                <option value=<?= $u['id'] ?>><?= $u['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="item_barcode" name="item_barcode" placeholder="Item barcode...">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="item_name" name="item_name" placeholder="Item name...">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mt-2" id="item_brand" name="item_brand" placeholder="Item brand...">
                    </div>
                    <div class="form-group">
                        <label for="item_type">Item Type:</label>
                        <select id="item_type" name="item_type" class="fstdropdown-select form-control">
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Kandang">Kandang</option>
                            <option value="Mainan">Mainan</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Obat">Obat</option>
                            <option value="Pasir">Pasir</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control mt-2" id="item_amount" name="item_amount" placeholder="Item amount...">
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