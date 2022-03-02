<?php if(count($data) > 0){ ?>
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-wrap -m-4">
      <?php foreach ($data as $d) : ?>
        <div class="lg:w-1/3 sm:w-1/2 p-4">
          <div class="flex flex-col space-y-2 justify-center items-center h-40 text-md">
            <img alt="gallery" class="border rounded-md relative inset-0 w-full h-full object-contain object-center" src="<?= base_url('/' . $d->image_path) ?>">
            <div class="">
              <button class="btn btn-sm btn-danger" onclick="deleteimage('<?= $d->image_path ?>')">
                <i class="fa fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<script>
  function deleteimage(path) {
    const url = "<?= base_url('olshop/product/deleteimage') ?>";
    Swal.fire({
      title: 'Apa anda yakin?',
      text: "Anda akan menghapus gambar ini? ",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus gambar ini!'
    }).then((result) => {
      if (result.isConfirmed) {
        axios.post(url, {
            name: path
          })
          .then(function(response) {
            console.log(JSON.parse(response));
          })
          
          .catch(function(error) {
            console.log(error);
          });
      }
    })
  }
</script>
<?php } ?>