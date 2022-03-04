<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="<?= $region_id ?>"></label>
            <select name="<?= $region_id ?>" id="<?= $region_id ?>" class="form-control form-control-user">
                <option value=""></option>
            </select>
        </div>
    </div>
    <?php if($areas == 1){ ?>
    <div class="col-md-12">
        <div class="form-group">
            <label for="<?= $area_id ?>"></label>
            <select name="<?= $area_id ?>" id="<?= $area_id ?>" class="form-control form-control-user">
                <option value=""></option>
            </select>
        </div>
    </div>
    <?php } ?>
    <?php if($subdistrict == 1){ ?>
    <div class="col-md-12">
        <div class="form-group">
            <label for="<?= $subdistrict_id ?>"></label>
            <select name="<?= $subdistrict_id ?>" id="<?= $subdistrict_id ?>" class="form-control form-control-user">
                <option value=""></option>
            </select>
        </div>
    </div>
    <?php } ?>
</div>

