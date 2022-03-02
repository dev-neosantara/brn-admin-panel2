<?php

namespace App\Controllers;


class RenderImage extends BaseController
{
    public function index($path = null)
    {
        // print_r('render!');exit;
        // print_r($imageName);exit;
        $path = "uploads/20220102/1641167262_778dc329f20a27bc223f.png";
        if(($image = file_get_contents(WRITEPATH.$path)) === FALSE){
            $this->response
            ->setStatusCode(404);exit;
        }
        

        // choose the right mime type
        $mimeType = 'image/jpg';
        // print_r($image);exit;
        $inf = getimagesize($image);
        
        header("Content-type: {$inf['mime']}");
        readfile($image);exit;
    }

}