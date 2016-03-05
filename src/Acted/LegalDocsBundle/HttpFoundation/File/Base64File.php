<?php

namespace Acted\LegalDocsBundle\HttpFoundation\File;

use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 05.03.16
 * Time: 15:30
 */
class Base64File extends File
{
    public function __construct($base64Content, $type)
    {
        if(strpos($base64Content, 'data:'.$type.';base64') !== 0) {
            throw new InvalidArgumentException;
        }
        $img = $base64Content;
        $img = str_replace('data:'.$type.';base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $filePath = tempnam(sys_get_temp_dir(), 'UploadedFile').'.png';

        $file = fopen($filePath, "w");
        stream_filter_append($file, 'convert.base64-decode');
        fwrite($file, $img);
        $meta_data = stream_get_meta_data($file);
        $path = $meta_data['uri'];
        fclose($file);
        parent::__construct($path, true);
    }

}