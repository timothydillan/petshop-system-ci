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
    <?= $this->session->flashdata('message') ?>
    <!-- Content Row -->
    <form action="<?= base_url() ?>admin/savegroom/<?= $id ?>" method="post">
        <div class="form-group">
            <label for="shop_id">Shop:</label>
            <select id="shop_id" name="shop_id" class="form-control">
                <?php foreach ($shops as $s) : ?>
                    <option value=<?= $s['id'] ?> <?php if ($s['id'] == $shopid) {
                                                        echo "selected";
                                                    } ?>><?= $s['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="member_id">Member:</label>
            <select id="member_id" name="member_id" class="fstdropdown-select form-control">
                <option value=<?= $id ?> selected><?= $name ?></option>
                <?php foreach ($members as $m) :
                    if ($m['id'] == $id)
                        continue; ?>
                    <option value=<?= $m['id'] ?>><?= $m['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="animal">Animal:</label>
            <input type="text" class="form-control" id="animal" name="animal" placeholder="Enter animal.." , value="<?= $animal ?>">
        </div>
        <div class="form-group">
            <label for="race">Animal Race:</label>
            <input type="text" class="form-control" id="race" name="race" placeholder="Enter animal race.." , value="<?= $race ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><? echo $description; ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Enter grooming price.." , value="<?= $price ?>">
        </div>
        <p>Pay with: </p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Cash" <? if($payment_method=="Cash" ) echo "checked" ; ?>>
            <label class="form-check-label" for="inlineRadio1">Cash</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Debit" <? if($payment_method=="Debit" ) echo "checked" ; ?>>
            <label class="form-check-label" for="inlineRadio2">Debit</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method" value="Bon" <? if($payment_method=="Bon" ) echo "checked" ; ?>>
            <label class="form-check-label" for="inlineRadio3">Bon</label>
        </div>
        <div class="form-group mt-3">
            <label for="paid">Paid?</label>
            <select id="paid" name="paid" class="form-control">
                <option value=0 <?php if ($paid == 0) {
                                    echo "selected";
                                } ?>>False</option>
                <option value=1 <?php if ($paid == 1) {
                                    echo "selected";
                                } ?>>True</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
        <button type="button" onclick="goBack()" class="btn btn-secondary">Cancel</button>
    </form>
</div>