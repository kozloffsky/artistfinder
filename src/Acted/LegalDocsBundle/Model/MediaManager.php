<?php

namespace Acted\LegalDocsBundle\Model;
use Acted\LegalDocsBundle\Entity\Media;
use Embed\Embed;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 11.03.16
 * Time: 11:49
 */
class MediaManager
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function updatePhoto(File $file, Media $media)
    {
        $media->setActive(true);
        $media->setMediaType('photo');
        $media->setPosition(1);
        if ($file instanceof UploadedFile) {
            $media->setName($file->getClientOriginalName());
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        } else {
            $media->setName(uniqid());
            $fileName = $media->getName() . '.' . $file->getExtension();
        }

        if (!file_exists($this->dir) && !is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }

        $media->setLink($file->move($this->dir, $fileName));
        $media->setThumbnail('');
        return $media;
    }

    public function updateVideo($link, Media $media)
    {
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
            }
            $media->setThumbnail($videoInfo->getImage());
            $media->setName($videoInfo->getTitle());
        }

        return $media;
    }

    public function updateAudio($link, Media $media)
    {
        $media->setActive(true);
        $media->setMediaType('audio');
        $media->setPosition(1);
        $media->setLink($link);
        $media->setName($link);

        $audioInfo = Embed::create($link);
        if($audioInfo) {
            $media->setName($audioInfo->getTitle());
        }

        return $media;
    }

}