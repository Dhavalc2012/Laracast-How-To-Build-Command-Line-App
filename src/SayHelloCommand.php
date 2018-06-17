<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 16/6/18
 * Time: 11:36 PM
 */

namespace CJ;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SayHelloCommand extends Command
{

    public function configure()
    {
        $this->setName('SayHelloTo')
            ->setDescription('Offer A Greeting To The Person')
            ->addArgument('name', InputArgument::REQUIRED,'Your Name Is Required')
            ->addOption('greeting',null,InputOption::VALUE_OPTIONAL,'Override the default greetings','Hello');


    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $message = sprintf("%s, %s",$input->getOption('greeting'),$name);
        $output->writeln("<comment>{$message}</comment>");
    }
}