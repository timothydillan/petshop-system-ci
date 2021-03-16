<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>admin/saveshipping/<?= $current_shipping_id ?>/<?= $id ?>" method="post">
        <div class="form-group">
            <label for="item_id">Item Name:</label>
            <select id="item_id" name="item_id" class="fstdropdown-select form-control">
                <option value=<?= $item_id ?> selected><?= $item_name ?></option>
                <?php foreach ($inv as $i) :
                    if ($i['id'] == $item_id)
                        continue; ?>
                    <option value=<?= $i['id'] ?>><?= $i['item_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="item_jumlah">Item Amount:</label>
            <input type="number" class="form-control mt-2" id="item_jumlah" name="item_jumlah" placeholder="Item Amount" value="<?= $item_jumlah ?>">
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>