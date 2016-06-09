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
    private $lip;

    public function __construct($dir, $lip)
    {
        $this->dir = $dir;
        $this->lip = $lip;
    }

    public function updatePhoto(File $file, Media $media, $request)
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

        $media->setLink('/'.$file->move($this->dir, $fileName));
        $media->setThumbnail('');

        /**Generate thumbnail**/
        $small = $this->lip->filterAction($request, $media->getLink(), 'small');
        $medium = $this->lip->filterAction($request, $media->getLink(), 'medium');

        return $media;
    }

    public function updateVideo($link, Media $media)
    {
        if (strripos($link, 'youtube.com') === false && strripos($link, 'vimeo.com') === false
            &&  strripos($link, 'youtu.be') === false ) {
            return ['error' => 'Added link should be from "youtube.com" or "vimeo.com"'];
        }
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
        if (strripos($link, 'soundcloud.com') === false) {
            return ['error' => 'Added link should be from "soundcloud.com"'];
        }
        if (strripos($link, 'iframe') === false) {
            return ['error' => 'Added link should be embed'];
        }
        $media->setActive(true);
        $media->setMediaType('audio');
        $media->setPosition(1);

        preg_match('/src="([^"]+)"/', $link, $audioPath);
        if (isset($audioPath[1])) {
            $media->setLink($audioPath[1]);
            $media->setName($audioPath[1]);
        }

        return $media;
    }

    public function uploadFile($file)
    {
        return '';
    }

}