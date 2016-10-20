<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 14.03.16
 * Time: 19:12
 */

namespace Acted\LegalDocsBundle\Model;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Profile;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Popo\RegisterUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class UserManager
{
    /**
     * @var EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    protected $mailer;

    protected $mailFrom;

    protected $avatarDir;

    protected $searchImageDir;

    protected $rootDir;

    /**
     * @var LiipImagineBundle
     */
    private $lip;

    public function __construct(EncoderFactoryInterface $encoderFactory,
                                EntityManagerInterface $entityManagerInterface, $mailer,
                                EngineInterface $templating, UrlGeneratorInterface $router, $mailFrom,
                                $lip, $avatarDir, $searchImageDir, $rootDir)
    {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManagerInterface;
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->mailFrom = $mailFrom;
        $this->lip = $lip;
        $this->avatarDir = $avatarDir;
        $this->searchImageDir = $searchImageDir;
        $this->rootDir = $rootDir;
    }

    public function newUser(RegisterUser $registerUser)
    {
        $user = new User();
        $user->setFirstname($registerUser->getFirstname());
        $user->setLastname($registerUser->getLastname());
        $user->setEmail($registerUser->getEmail());
        $user->setTempPassword($registerUser->getTempPassword());
        $user->setFake($registerUser->getFake());

        $role = $this->entityManager->getRepository('ActedLegalDocsBundle:RefRole')->findOneByCode($registerUser->getRole());

        if(!$role) {
            throw new \InvalidArgumentException();
        }

        $user = $this->updatePassword($user, $registerUser->getPassword());
        $user->setConfirmationToken($this->generateToken());
        $user->addRole($role);

        return $user;
    }

    public function updatePassword(User $user, $plainPassword)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        $user->setPasswordHash($encoder->encodePassword($plainPassword, $user->getSalt()));
        return $user;
    }

    public function newProfile(RegisterUser $registerUser) {
        $profile = new Profile();
        $profile->setTitle($registerUser->getName());
        $profile->setPaymentTypeId(1);
        foreach ($registerUser->getCategories() as $category) {
            $profile->addCategory($category);
        }

        return $profile;
    }

    public function newArtist(RegisterUser $registerUser) {
        $artist = new Artist();
        $artist->setName($registerUser->getName());
        $artist->setSlug($registerUser->getName());
        $artist->setCountry($registerUser->getCountry());
        $artist->setCity($registerUser->getCity());

        return $artist;
    }

    public function sendConfirmationEmailMessage(User $user)
    {
        $url = $this->router->generate('security_confirm', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render('@ActedLegalDocs/Security/confirmation.txt.twig', [
            'user' => $user,
            'confirmationUrl' =>  $url
        ]);
        $this->sendEmailMessage($rendered, $this->mailFrom, $user->getEmail());
    }

    public function confirmationForCreatedUser(User $user)
    {
        $url = $this->router->generate('security_resend_token', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $homepageUrl = $this->router->generate('acted_legal_docs_homepage', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render('@ActedLegalDocs/Security/create_user_confirmation.html.twig', [
            'user' => $user,
            'confirmationUrl' =>  $url,
            'homepageUrl' => $homepageUrl .'#how-it-works'
        ]);
        $this->sendEmailMessage($rendered, $this->mailFrom, $user->getEmail());
    }

    public function sendResettingEmailMessage(User $user)
    {
        $url = $this->router->generate('security_resetting_reset', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render('@ActedLegalDocs/Security/resetting.txt.twig', [
            'user' => $user,
            'confirmationUrl' =>  $url
        ]);
        $this->sendEmailMessage($rendered, $this->mailFrom, $user->getEmail());
    }

    public function generateToken()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
    }

    protected function getRandomNumber()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }

    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    public function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    /**
     * @param $filePath
     * @param User $user
     * @param $request
     * @return User
     */
    public function updateAvatar($filePath, User $user, $request)
    {
        if (!file_exists($this->avatarDir) && !is_dir($this->avatarDir)) {
            mkdir($this->avatarDir, 0777, true);
        }

        $fileName = explode('.', basename($filePath));
        $fileExtension = $fileName[1];

        $fileName = uniqid(). '.' . $fileExtension;

        //remove old avatar images
        $path = $this->rootDir . '/../web/images/avatars/*.*';
        array_map('unlink', glob($path));

        //move temp file to avatars
        rename($this->rootDir . '/../web' . $filePath, $this->rootDir . '/../web/images/avatars/' . $fileName);

        //remove temp images
        $path = $this->rootDir . '/../web/images/UploadedFile*.*';
        array_map('unlink', glob($path));

        $user->setAvatar($this->avatarDir . '/' . $fileName);

        return $user;
    }

    /**
     * @param File $file
     * @param Artist $artist
     * @param $request
     * @return Artist
     */
    public function updateSearchImage(File $file, Artist $artist, $request)
    {
        $fileName = uniqid(). '.' . $file->getExtension();

        if (!file_exists($this->searchImageDir) && !is_dir($this->searchImageDir)) {
            mkdir($this->searchImageDir, 0777, true);
        }

        $this->lip->filterAction($request, '/'.$file->move($this->searchImageDir, $fileName), 'search_image_thumbnail');

        $fileTemporal = new File('media/cache/search_image_thumbnail/images/search_images/' . $fileName);

        if (!file_exists($this->searchImageDir . '/thumbnail') && !is_dir($this->searchImageDir . '/thumbnail')) {
            mkdir($this->searchImageDir . '/thumbnail', 0777, true);
        }

        $fileTemporal->move($this->searchImageDir . '/thumbnail', $fileName);

        $path = $this->rootDir . '/../web/images/UploadedFile*.*';
        array_map('unlink', glob($path));

        $searchImage = $artist->getSearchImage();
        if (!empty($searchImage) && $searchImage != '/') {
            $searchImage = explode('/', $searchImage);
            $fileNameOld = array_pop($searchImage);
            $basePath = implode('/', $searchImage);

            $fileNameOldThumbnail = implode('/', array($basePath, 'thumbnail', $fileNameOld));
            $fileNameOldBase = implode('/', array($basePath, $fileNameOld));

            $path = $this->rootDir . '/../web' . $fileNameOldThumbnail;
            if(file_exists($path)){
                unlink($path);
            }

            $path = $this->rootDir . '/../web' . $fileNameOldBase;
            if(file_exists($path)) {
                unlink($path);
            }
        }


        $artist->setSearchImage($this->searchImageDir . '/' . $fileName);

        return $artist;
    }
}