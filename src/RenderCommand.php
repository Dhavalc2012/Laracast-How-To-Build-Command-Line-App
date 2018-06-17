<?php
/**
 * Created by PhpStorm.
 * User: dhaval
 * Date: 17/6/18
 * Time: 11:32 PM
 */

namespace CJ;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RenderCommand extends Command{
    public function configure()
    {
        $this->setName('render')->setDescription('Render Some Tabular Data');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
            $table = new Table($output);
            $table->setHeaders(['Name','Age'])->setRows([
                ['Hane Doe','33'],
                ['Joye','21']
            ])->render();
    }
}