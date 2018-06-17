<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 17/6/18
 * Time: 10:41 PM
 */

namespace CJ;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\ClientInterface;
use ZipArchive;
class NewCommand extends Command{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    public function configure()
{
    $this->setName('new')
        ->setDescription('Create A New Application.')
        ->addArgument('name',InputArgument::REQUIRED);
}

public function execute(InputInterface $input, OutputInterface $output)
{
     //assert that the folder already doesn't exist
    $directory = getcwd(). '/' . $input->getArgument('name');
    $this->assertApplicationDoesNotExist($directory,$output);

    $output->writeln('<info> Crafting Application... </info>');

    //download nightly version of laravel
    $this->download($zipFile = $this->makeFileName());

    //extract zip file
    $this->extract($zipFile , $directory);

    //Clean up after extract
    $this->cleanUp($zipFile);

    //Alert the user that they are ready to go.
    $output->writeln('<comment>Application Ready</comment>');
}

    private function assertApplicationDoesNotExist($directory,OutputInterface $output)
    {
        if(is_dir($directory)){
            $output->writeln('<error>Application Already Exist</error>');
            exit(1);
        }
    }

    private function download($zipFile)
    {
        $response = $this->client->get('http://cabinet.laravel.com/latest.zip')->getBody();
        file_put_contents($zipFile,$response);
        return $this;
    }

    private function makeFileName()
    {
        return getcwd().'/laravel_'.md5(time().uniqid()).'.zip';
    }

    private function extract($zipFile,$directory)
    {
        $archive = new ZipArchive;
        $archive->open($zipFile);
        $archive->extractTo($directory);
        $archive->close();
        return $this;


    }

    private function cleanUp($zipFile)
    {
        @chmod($zipFile,0777);
        @unlink($zipFile);

        return $this;
    }
}