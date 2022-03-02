<select name="<?= $id ?>" id="<?= $id ?>" class="<?= $classes ?>" tabindex="<?= $tabindex ?>">
    <option value="">Pilih Kategori</option>
    <?php foreach($data as $d): ?>
        <option value="<?= $d->cat_code ?>" <?php echo isset($data_id) && ($data_id === $d->cat_code || $data_id === $d->id) ? "selected" : ""; ?>><?= $d->cat_name ?></option>
    <?php endforeach; ?>
</select>