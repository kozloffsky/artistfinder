<?php

namespace Acted\LegalDocsBundle\Model;
use Acted\LegalDocsBundle\Entity\Media;
use Embed\Embed;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 11.03.16
 * Time: 11:49
 */
class MediaManager
{
    public function newPhoto(UploadedFile $file)
    {
        $media = new Media();
        $media->setActive(true);
        $media->setMediaType('photo');
        $media->setPosition(1);
        $media->setName($file->getClientOriginalName());
        $fileName = uniqid().'.'.$file->getClientOriginalExtension();
        $media->setLink($file->move('images', $fileName));
        return $media;
    }

    public function newVideo($link)
    {
        $media = new Media();
        $media->setActive(true);
        $media->setMediaType('video');
        $media->setPosition(1);
        $media->setLink($link);
        $media->setName($link);

        $videoInfo = Embed::create($link);
        if($videoInfo) {
            preg_match('/src="(.+?)"/', $videoInfo->getCode(), $videoLinkMatch);
            if(isset($videoLinkMatch[1])) {
                $media->setLink($videoLinkMatch[1]);
                $media->setThumbnail($videoInfo->getImage());
                $media->setName($videoInfo->getTitle());
            }
        }

        return $media;
    }

}