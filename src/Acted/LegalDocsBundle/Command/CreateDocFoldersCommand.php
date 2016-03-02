<?php
namespace Acted\LegalDocsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDocFoldersCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('docfolders:create')
            ->setDescription('Create Legal Doc Folders')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $this->getContainer()->get('kernel')->getRootDir();
        $path = str_replace('/app', '/web', $path);

        $path1 = $path . '/docs/performace_contract';
        $path2 = $path . '/docs/invoice_type';
        $path3 = $path . '/docs/quotation_type';

        try {
            $oldmask = umask(0);
            mkdir($path1, 0777, true);
            mkdir($path2, 0777, true);
            mkdir($path3, 0777, true);
            umask($oldmask);
        } catch (\Exception $e) {
            echo 'Got error: ', $e->getMessage(), "\n";
        }

        $output->writeln('command finished');
    }
}