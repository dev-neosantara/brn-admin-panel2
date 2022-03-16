<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Config('Brn')->settings['app_name']['value'] ?></title>
    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/lib/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .qr{
            width: 300px;
            height: 300px;
        }
        @media print{
            .print{
                display: none!important;
            }
        }
    </style>
</head>

<body>
    <div class="flex justify-start items-center px-2 print">
        <button class="px-2 py-1 rounded-md border bg-blue-400 text-white" onclick="cetak()">Cetak</button>
        <button class="px-2 py-1 rounded-md border bg-blue-400 text-white" onclick="window.history.back()">Kembali</button>
    </div>
    <div class="flex justify-center w-screen h-screen">
        <div class="flex flex-col justify-center items-center text-center w-10/12 p-2 border my-2">
            <h1><?= $data->title; ?></h1>
            <p>Start <?= date('d, M Y', strtotime($data->start_date)); ?></p>
            <div class="flex flex-col items-center justify-center p-2 border my-10 text-center">
                <p>Scan Qr ini Untuk Absen</p>
                <img src="<?= $data->qr_path ?>" alt="QR Code" class="w-62 h-62">
            </div>
            <p><?= $data->description; ?></p>
            
        </div>
    </div>
</body>

<script>
    function cetak() {
        window.print();
    }
</script>

</html>