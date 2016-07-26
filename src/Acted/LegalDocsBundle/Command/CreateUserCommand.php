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
                InputArgument::OPTIONAL,
                'user email'
            )
            ->addArgument(
                'password',
                InputArgument::OPTIONAL,
                'user password'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $userRepo = $em->getRepository('ActedLegalDocsBundle:User');

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Not valid email');
        }
        if (!$password) {
            throw new Exception('Not valid password');
        }
        /** validate password */
        if ($this->validationPassword($password)['status']) {
            throw new Exception($this->validationPassword($password)['message']);
        }
        /** Check exist email */
        $admin = $userRepo->findOneBy(['email' => $email]);
        if ($admin) {
            throw new Exception(sprintf('Admin with email %s already exist!', $email));
        }

        $encoder = $this->getContainer()->get('security.password_encoder');
        $roleRepo = $em->getRepository('ActedLegalDocsBundle:RefRole');
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

        $output->writeln(sprintf('New admin create successfully! email: %s , password: %s', $email, $password ));
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