<?php

namespace Acted\LegalDocsBundle\Command;

use Acted\LegalDocsBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('create:admin')
            ->setDescription('Create new admin')
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'user email'
            )
            ->addArgument(
                'flag',
                InputArgument::REQUIRED,
                'ability flag'
            )
            ->addArgument(
                'password',
                InputArgument::OPTIONAL,
                'user password'
            )
            ->addArgument(
                'search_email',
                InputArgument::OPTIONAL,
                'email for search'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $userRepo = $em->getRepository('ActedLegalDocsBundle:User');
        $email = $input->getArgument('email');
        $searchEmail = $input->getArgument('search_email');
        $password = $input->getArgument('password');
        $encoder = $this->getContainer()->get('security.password_encoder');
        $roleRepo = $em->getRepository('ActedLegalDocsBundle:RefRole');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Not valid email');
        }

        switch ($input->getArgument('flag')){
            case 'create':
                $this->createUser($email, $password, $userRepo, $roleRepo, $encoder, $em);
                $output->writeln(sprintf('New admin create successfully! email: %s , password: %s', $email, $password ));
                break;
            case 'edit':
                $this->editUser($email, $password, $encoder, $userRepo, $em, $searchEmail);
                $output->writeln(sprintf('Admin edit successfully! email: %s , password: %s', $email, $password ));
                break;
            case 'delete':
                $user = $userRepo->findOneByEmail($email);
                $em->remove($user);
                $em->flush();

                $output->writeln(sprintf('Admin delete successfully! email: %s ', $email));
                break;
        }
    }

    /**
     * @param string $email
     * @param string $searchEmail
     * @param string $password
     * @param $encoder
     * @param $userRepo
     * @param $em
     */
    private function editUser($email, $password, $encoder, $userRepo, $em, $searchEmail)
    {
        $editAdmin = $userRepo->findOneBy(['email' => $searchEmail]);
        $editAdmin->setEmail($email);
        /** validate password */
        if($password) {
            if ($this->validationPassword($password)['status']) {
                throw new Exception($this->validationPassword($password)['message']);
            }
            $editAdmin->setPasswordHash($encoder->encodePassword($editAdmin, $password));
        }

        $em->persist($editAdmin);
        $em->flush();
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $userRepo
     * @param $roleRepo
     * @param $encoder
     * @param $em
     */
    private function createUser($email, $password, $userRepo, $roleRepo, $encoder, $em)
    {
        /** Check exist email */
        $admin = $userRepo->findOneBy(['email' => $email]);
        if (!$password) {
            throw new Exception('Not valid password');
        }
        /** validate password */
        if ($this->validationPassword($password)['status']) {
            throw new Exception($this->validationPassword($password)['message']);
        }
        if ($admin) {
            throw new Exception(sprintf('Admin with email %s already exist!', $email));
        }
        $adminRole = $roleRepo->findOneBy(['code' => 'ROLE_ADMIN']);
        /**
         * Create new user
         */
        $user = new User();
        $user->setFirstname($email);
        $user->setLastname($email);
        $user->setActive(1);
        $user->setEmail($email);
        $user->addRole($adminRole);
        $user->setPasswordHash($encoder->encodePassword($user, $password));

        $em->persist($user);
        $em->flush();
    }

    /**
     * Validate password for admin
     * @param string $password
     * @return array
     */
    private function validationPassword($password)
    {
        if (strlen($password) < 8) {
            $result = [
                'status' => true,
                'message' => 'Your Password Must Contain At Least 8 Characters!'
            ];
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $result = [
                'status' => true,
                'message' => 'Your Password Must Contain At Least 1 Number!'
            ];
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $result = [
                'status' => true,
                'message' => 'Your Password Must Contain At Least 1 Capital Letter!'
            ];
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $result = [
                'status' => true,
                'message' => 'Your Password Must Contain At Least 1 Lowercase Letter!'
            ];
        } else {
            $result = [
                'status' => false,
                'message' => 'ok'
            ];
        }

        return $result;
    }
}