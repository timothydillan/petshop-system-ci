<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>toko/saveinventory/<?= $item_id ?>" method="post">
        <div class="form-group">
            <label for="item_barcode">Item Barcode:</label>
            <input type="text" class="form-control mt-2" id="item_barcode" name="item_barcode" placeholder="Item barcode..." value="<?= $item_barcode ?>">
        </div>
        <div class="form-group">
            <label for="item_name">Item Name:</label>
            <input type="text" class="form-control mt-2" id="item_name" name="item_name" placeholder="Item name..." value="<?= $item_name ?>">
        </div>
        <div class="form-group">
            <label for="item_brand">Item Brand:</label>
            <input type="text" class="form-control mt-2" id="item_brand" name="item_brand" placeholder="Item brand..." value="<?= $item_brand ?>">
        </div>
        <div class="form-group">
            <label for="item_type">Item Type:</label>
            <select id="item_type" name="item_type" class="fstdropdown-select form-control">
                <option value="Aksesoris" <?php if ($item_type == "Aksesoris") echo "selected";  ?>>Aksesoris</option>
                <option value="Kandang" <?php if ($item_type == "Kandang") echo "selected";  ?>>Kandang</option>
                <option value="Mainan" <?php if ($item_type == "Mainan") echo "selected";  ?>>Mainan</option>
                <option value="Makanan" <?php if ($item_type == "Makanan") echo "selected";  ?>>Makanan</option>
                <option value="Obat" <?php if ($item_type == "Obat") echo "selected";  ?>>Obat</option>
                <option value="Pasir" <?php if ($item_type == "Pasir") echo "selected";  ?>>Pasir</option>
                <option value="Lain-lain" <?php if ($item_type == "Lain-lain") echo "selected";  ?>>Lain-lain</option>
            </select>
        </div>
        <div class="form-group">
            <label for="item_amount">Item Amount:</label>
            <input type="number" class="form-control mt-2" id="item_amount" name="item_amount" placeholder="Item amount..." value="<?= $item_amount ?>">
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
    </form>
</div>