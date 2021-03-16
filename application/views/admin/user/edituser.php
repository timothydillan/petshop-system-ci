<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>admin/saveuser/<?= $id ?>" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $name ?>">
        </div>
        <div class="form-group">
            <label for="name">Email:</label>
            <input type="text" class="form-control mt-2" id="email" name="email" placeholder="Email" value="<?= $email ?>">
        </div>
        <div class="form-group">
            <label for="role_id">Choose a Role:</label>
            <select id="role_id" name="role_id" class="form-control">
                <option value=1 <?php if ($role_id == 1) {
                                    echo "selected";
                                } ?>>Admin/Master</option>
                <option value=2 <?php if ($role_id == 2) {
                                    echo "selected";
                                } ?>>Kantor</option>
                <option value=3 <?php if ($role_id == 3) {
                                    echo "selected";
                                } ?>>Toko</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>