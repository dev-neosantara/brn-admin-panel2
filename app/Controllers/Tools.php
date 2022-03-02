<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\CLI\CLI;
use App\Libraries\FCM;

class Tools extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }

    public function sendnotiftest()
    {
        // CLI::write(ROOTPATH);exit;
        $fcm = new FCM();
        $data = array(
            'title' => 'Test Notif Dari server',
            'message' => 'TESTASTATAT',
            'body' => 'ASDASDASDASDASD'

        );
        $fcm->send("AAAA-PAeDNU:APA91bHqWFr-AFx9wupKrcgPLG2Rs4QvHi0w2Z5jBXahzRqv6zaAXdS08dLKiDGOvkvifcRxxjeEZIEpPJZAIlojsiTmAg4b6jL9vo_cUEWvimGcHbyM9qoC5Nay0IOuLtpzAnjCl927", "d0CcA26eRI6oASr3Kw2UeD:APA91bH7W4qrhpRoETmR0o3RYAMLgNEe4tZ4ZwN892sTwX1j2Rfo32RRiS1aMOO2YzLuDyovDyp_B1oEyapmxUTE2a98F1uHFI3fdra1O4cKobtpGrGrI_iHWClFA5IEX1-IC3DPiAxy", "Test Notif Manual dari admin", "test admin", $data);
    }
}
