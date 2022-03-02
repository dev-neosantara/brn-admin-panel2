<?= $this->extend('App\Views\template') ?>
<?= $this->section('head') ?>
<!-- Custom styles for this page -->
<!-- <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/rg-1.1.4/sc-2.0.5/sp-1.4.0/datatables.min.css" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Data Produk</h1> -->
<!-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                        For more information about DataTables, please visit the <a target="_blank"
                            href="https://datatables.net">official DataTables documentation</a>.</p> -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data <?= $title ?></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="articleTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <?php if ($role != 'new') { ?>
                            <th>No ID</th>
                        <?php } ?>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <?php if ($role != 'new') { ?>
                            <th>No ID</th>
                        <?php } ?>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('foot') ?>
<!-- Page level custom scripts -->
<!-- <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/r-2.2.9/rg-1.1.4/sc-2.0.5/sp-1.4.0/datatables.min.js"></script>

<script>
    var tbl;
    const baseUrl = "<?= base_url('users') ?>";
    const role = "<?= $role ?>";
    $(document).ready(function() {
        tbl = $('#articleTable').DataTable({
            dom: 'lBfrtip',
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ajax: baseUrl + "/list/" + role,
            buttons: {
                buttons: [
                    <?php if ($role != 'new' && $role != 'ext') { ?> `<a href="${baseUrl}/tambah/${role}" class="btn btn-primary btn-sm flex justify-center items-center"><i class="fas fa-plus"></i>&nbsp;Tambah Member</a>`
                    <?php } ?>
                ]
            },
            columnDefs: [{
                    targets: 0,
                    orderable: false
                },
                {
                    targets: <?php echo $role != 'new' ? 4 : 3 ?>,
                    render: function(data, type, full, meta) {
                        // u.name, u.email, p.id_card, u.id, u.payment_status as payment, u.check_korda as vkorda, u.check_korwil as vkorwil
                        let res = "";
                        const check = `<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
                        // const uncheck = ``;
                        if(parseInt(full[8]) == 0){
                            let payment = full[5] == 1 ? check : '';
                            let korda = full[6] == 1 ? check : '';
                            let korwil = full[7] == 1 ? check : '';
                            if (type == 'display') {
                                res += `
                                <p class="flex border-b">Payment&nbsp;${payment}</p>
                                <p class="flex border-b">Verif Korwil&nbsp;${korwil}</p>
                                <p class="flex border-b">Verif Korda&nbsp;${korda}</p>
                                `;
                            }
                        }else{
                            let point = full[9] == null ? 0 : full[9];
                            if (type == 'display') {
                                res += `
                                <p class="flex items-center space-x-4"><span>Point : ${point}</span><a href="#" class=" text-blue-400 underline opacity-50 hover:opacity-100">Detail</a></p>
                                `;
                            }
                        }

                        return res;
                    }
                },
                
                {
                    targets: 3,
                    render: function(data, type, full, meta) {
                        // u.name, u.email, p.id_card, u.id, u.payment_status as payment, u.check_korda as vkorda, u.check_korwil as vkorwil
                        if(role == 'new'){
                            return false;
                        }
                        let res = "";
                        if (type == 'display') {
                                if(full[3] == "" || full[3] == null){
                                    res = `<button onclick='generate(${JSON.stringify(full)})' class="opacity-50 hover:opacity-100 px-3 py-1 rounded-md border text-sm">Generate ID MEMBER?</button>`;
                                }else{
                                    res = `
                                <p class="flex border-b">${full[3]}</p>
                                `;
                                }
                                
                            }

                        return res;
                    }
                },
               
                {
                    targets: <?php echo $role != 'new' ? 5 : 4 ?>,
                    render: function(data, type, full, meta) {
                        let res = `<div class="flex flex-col justify-center items-center">`;
                        if (type === 'display') {
                            if((full[10] == 'registration' || full[10] == 'extension') && full[5] == 1 && full[6] == 1 && full[7] == 1){
                                res += `
                                    <button class="opacity-50 hover:opacity-100 border rounded-lg p-1 bg-green-400 flex space-x-1" onclick='publish(${JSON.stringify(full)})'><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg><span class="text-white">Konfirmasi</span></button>
                                `;
                            }else if((full[10] == 'registration' || full[10] == 'extension') && (full[5] == 0 || full[6] == 0 || full[7] == 0) && full[8] == 0){
                                res += `
                                    <button class="border rounded-lg p-1 bg-green-400 flex space-x-1" disabled><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg><span class="text-white">Persyaratan belum lengkap!</span></button>
                                `;
                            }

                            res += `<a class="border rounded-lg py-1 px-1 bg-blue-400 text-white text-sm w-full text-center" href="<?= base_url('users/') ?>">Detail User</a>`
                            
                        }
                        res += `</div>`;
                        return res;
                    }
                }
            ]

        });

        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            console.log(message);
        };
    });

    function createManageBtn() {
        return '<button id="manageBtn" type="button" onclick="myFunc()" class="btn btn-success btn-xs">Manage</button>';
    }

    function myFunc() {
        console.log("Button was clicked!!!");
    }

    function publish(datas) {
        // console.log(datas);
        const url = `<?= base_url('users/konfirmasi/') ?>/${datas[4]}`;
        const check = `<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
        // const uncheck = ``;
        let payment = datas[5] == 1 ? check : '';
        let korda = datas[6] == 1 ? check : '';
        let korwil = datas[7] == 1 ? check : '';
        Swal.fire({
            title: 'Verifikasi?',
            html: `
                <div class="grid grid-cols-3 px-4 py-2 border-b gap-2">
                    <div class="grid col-span-1 text-right">
                        Nama
                    </div>
                    <div class="grid col-span-2 text-left">
                        ${datas[1]}
                    </div>    
                </div>
                <div class="grid grid-cols-3 px-4 py-2 border-b gap-2">
                    <div class="grid col-span-1 text-right">
                        Email
                    </div>
                    <div class="grid col-span-2 text-left">
                        ${datas[2]}
                    </div>    
                </div>
                <div class="grid grid-cols-3 px-4 py-2 border-b gap-2">
                    <div class="grid col-span-1 text-right">
                        ID Member
                    </div>
                    <div class="grid col-span-2 text-left">
                        ${datas[3]}
                    </div>    
                </div>
                <div class="grid grid-cols-2 px-4 py-2 border-b gap-2">
                    <div class="grid">
                        Payment
                    </div>  
                    <div>${payment}</div>   
                </div>
                <div class="grid grid-cols-2 px-4 py-2 border-b gap-2">
                    <div class="grid">
                        
                        Verif Korwil
                        
                    </div>   
                    <div>${korwil}</div>  
                </div>
                <div class="grid grid-cols-2 px-4 py-2 border-b gap-2">
                    <div class="grid">
                        Verif Korda
                    </div> 
                    <div>${korda}</div> 
                </div>
                
                
                `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, konfirmasi user ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error == 0) {
                            Swal.fire(
                                'Berhasil!',
                                data.message,
                                'success'
                            ).then(() => {
                                tbl.ajax.reload()
                            });

                            return;
                        }
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    });

            }
        })
    }

    function generate(datas) {
        // console.log(datas);
        const url = `<?= base_url('users/tool/generateid') ?>/${datas[4]}`;
        Swal.fire({
            title: 'Verifikasi?',
           text: "Generate no id member untuk user ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, konfirmasi user ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error == 0) {
                            Swal.fire(
                                'Berhasil!',
                                data.message,
                                'success'
                            ).then(() => {
                                tbl.ajax.reload()
                            });

                            return;
                        }
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    });

            }
        })
    }

    function deletepro(name, id) {
        const url = "<?= base_url('olshop/product/delete') ?>/" + id;
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Anda akan menghapus produk " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus produk ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error == 0) {
                            Swal.fire(
                                'Deleted!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });

                            return;
                        }
                        Swal.fire(
                            'Error!',
                            data.message,
                            'error'
                        );
                    });

            }
        })
    }
</script>
<?= $this->endSection() ?>