<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>admin/savemember/<?= $id ?>" method="post">
        <div class="form-group">
            <label for="shop_id">Shop:</label>
            <select id="shop_id" name="shop_id" class="form-control">
                <?php foreach ($shops as $s) : ?>
                    <option value=<?= $s['id'] ?> <?php if ($s['id'] == $shop_id) {
                                                        echo "selected";
                                                    } ?>><?= $s['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Member Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $name ?>">
        </div>
        <div class="form-group">
            <label for="name">Member Phone:</label>
            <input type="text" class="form-control mt-2" id="phone" name="phone" placeholder="Phone" value="<?= $phone ?>">
        </div>
        <div class="form-group">
            <label for="name">Member Address:</label>
            <input type="text" class="form-control mt-2" id="address" name="address" placeholder="Adress" value="<?= $address ?>">
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>