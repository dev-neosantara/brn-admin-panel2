<form action="<?= isset($url) ? $url : 'https://api.brnjuara.com/api/upload-files' ?>" method="post" class="dropzone" id="<?= isset($id) ? $id : 'files' ?>">
    <!-- <div id="pdimg"></div> -->
    <div class="dz-message" data-dz-message><span><?= isset($text) ? $text : 'Klik atau jatuhkan file disini!' ?></span></div>
</form>