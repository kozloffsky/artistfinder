<?php

namespace Acted\LegalDocsBundle\Model;
use Acted\LegalDocsBundle\Entity\Media;
use Embed\Embed;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 11.03.16
 * Time: 11:49
 */
class MediaManager
{
    /**
     * @var string
     */
    private $dir;

    /**
     * @var LiipImagineBundle
     */
    private $lip;

    /**
     * @var array
     */
    private $fileFormats;

    /**
     * @var integer
     */
    private $maxFileSize;

    /**
     * @var string
     */
    private $chatUploadsDir;

    /**
     * MediaManager constructor.
     * @param string $dir
     * @param $lip
     * @param array $fileFormats
     * @param integer $maxFileSize
     * @param string $chatUploadsDir
     */
    public function __construct($dir, $lip, $fileFormats, $maxFileSize, $chatUploadsDir)
    {
        $this->dir = $dir;
        $this->lip = $lip;
        $this->fileFormats = $fileFormats;
        $this->maxFileSize = $maxFileSize;
        $this->chatUploadsDir = $chatUploadsDir;
    }

    /**
     * @param File $file
     * @param Media $media
     * @param $request
     * @return Media
     */
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

    /**
     * @param $link
     * @param Media $media
     * @return Media|array
     * @throws \Embed\Exceptions\InvalidUrlException
     */
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
                if (strripos($link, 'youtube.com') || strripos($link, 'youtu.be')) {
                    $media->setLink($videoLinkMatch[1] . '&enablejsapi=1&version=3&playerapiid=ytplayer');
                } else {
                    $media->setLink($videoLinkMatch[1]);
                }
            }
            $media->setThumbnail($videoInfo->getImage());
            $media->setName($videoInfo->getTitle());
        }

        return $media;
    }

    /**
     * @param string $link
     * @param Media $media
     * @return Media|array
     */
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

    /**
     * Upload file
     * @param array $uploadedFiles
     * @param string $filePath
     * @return array
     */
    public function uploadFilesForMessage($uploadedFiles, $filePath = null)
    {
        $result = ['status' => 'success'];
        foreach ($uploadedFiles as $uploadedFile) {
            $file = $this->uploadFile($uploadedFile, $filePath);
            if ($file['status'] === 'error') {
                return [
                    'status' => 'error',
                    'message' => $file['message'] . 'for file '. $uploadedFile->getClientOriginalName()
                ];
            } else {
                $result['message'][] = [
                    'path' => $file['message'],
                    'type' => $file['type']
                ];
            }
        }

        return $result;
    }

    /**
     * Upload file
     * @param UploadedFile $uploadedFile
     * @param string $filePath
     * @return array
     */
    private function uploadFile($uploadedFile, $filePath = null)
    {
        $fs = new Filesystem();

        /** Check mime type uploaded file */
        if (!in_array($uploadedFile->getClientMimeType(), $this->fileFormats)) {
            return [
                'status' => 'error',
                'message' => 'You try upload invalid format file'
            ];
        }

        /** Check size uploaded file */
        if ($uploadedFile->getClientSize() > $this->maxFileSize) {
            return [
                'status' => 'error',
                'message' => 'Max size upload file 15MB'
            ];
        }

        try {
            if (is_null($filePath)) {
                /** If not exist directory for upload */
                $filePath = $this->chatUploadsDir;

                if (!$fs->exists($filePath)) {
                    $fs->mkdir($filePath, 0777);
                }
            } else {
                /** If exist directory for upload */
                $filePath = $this->chatUploadsDir . '/' . $filePath;

                if (!$fs->exists($filePath)) {
                    $fs->mkdir($filePath, 0777);
                }
            }

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->move($filePath, $filename);
        } catch (\Exception $exp) {
            return [
                'status' => 'error',
                'message' => $exp->getMessage()
            ];
        }

        return [
            'status' => 'success',
            'message' => '/'.$filePath . '/' . $filename,
            'type' => $uploadedFile->getClientMimeType()
        ];
    }

    /**
     * Remove all file from system
     * @param User $user
     * @param array $messageFiles
     */
    public function removeFiles($user, $messageFiles)
    {
        $fs = new Filesystem();

        /** Remove message file */
        foreach ($messageFiles as $messageFile) {
            if ($fs->exists($messageFile->getFileName()) && $messageFile->getFileName() !== '/') {
                if($this->checkFileName($messageFile->getFileName())) {
                    $fs->remove($messageFile->getFileName());
                }
            }
        }

        /** Check background */
        if ($user->getBackground() && $fs->exists($user->getBackground()) && $user->getBackground() !== '/') {
            if ($this->checkFileName($user->getBackground())) {
                $fs->remove($user->getBackground());
            }
        }

        /** Check media */
        $userMedia = $user->getProfile()->getMedia()->toArray();

        foreach ($userMedia as $media) {
            if ($media->getMediaType() === 'photo' && $fs->exists('../web'.$media->getLink()) && $media->getLink()
                !== '/') {
                if ($this->checkFileName(str_replace('/', '', $media->getLink()))){
                    $fs->remove('../web'.$media->getLink());
                }
                /** Background thumbnail */
                if ($fs->exists('../web/media/cache/background' . $media->getLink())) {
                    if ($this->checkFileName(str_replace('/', '', $media->getLink()))){
                        $fs->remove('../web/media/cache/background' . $media->getLink());
                    }
                }
                /** Big thumbnail */
                if ($fs->exists('../web/media/cache/big' . $media->getLink())) {
                    if ($this->checkFileName(str_replace('/', '', $media->getLink()))){
                        $fs->remove('../web/media/cache/big' . $media->getLink());
                    }
                }
                /** Medium thumbnail */
                if ($fs->exists('../web/media/cache/medium' . $media->getLink())) {
                    if ($this->checkFileName(str_replace('/', '', $media->getLink()))){
                        $fs->remove('../web/media/cache/medium' . $media->getLink());
                    }
                }
                /** Small thumbnail*/
                if ($fs->exists('../web/media/cache/small' . $media->getLink())) {
                    if ($this->checkFileName(str_replace('/', '', $media->getLink()))){
                        $fs->remove('../web/media/cache/small' . $media->getLink());
                    }
                }
            }
        }
    }

    /**
     * Check file name
     * @param  string $name
     * @return boolean
     */
    private function checkFileName($name)
    {
        $nameArr = [];
        for ($i = 1; $i < 35; $i++) {
            $nameArr[] = $i . 'jpg';
            $nameArr[] = $i . 'png';
        }
        $result = true;
        if (!in_array($name, $nameArr)) {
            $result = false;
        }

        return $result;
    }

}