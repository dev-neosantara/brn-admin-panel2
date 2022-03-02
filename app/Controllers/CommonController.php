<?php

namespace App\Controllers;

class CommonController extends BaseController
{
    private $image_type = ['image/jpg', 'image/jpeg', 'image/png'];
    public function uploadfile()
    {
        $files = $this->request->getFiles();
        $res = [];
        foreach($files as $file){
            if (! $file->isValid()) {
                throw new \RuntimeException($file->getErrorString().'('.$file->getError().')');
                // echo json_encode(['error' => $file->getErrorString().'('.$file->getError().')']);exit;
                // $res[] = $file->getErrorString().'('.$file->getError().')';
            }
            $type = $file->getMimeType();
            // print_r($type);exit;
            $res[] = $file->store();
            
        }
        echo json_encode($res);exit;
    }
}
