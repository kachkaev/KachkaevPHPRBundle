<?php

namespace Kachkaev\RBundle\Command;

use Kachkaev\RBundle\R;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('r:test')
            ->setDescription('Tests r integration')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $r = $this->getContainer()->get('kachkaev_r.r');
        $result = $r->run('1+1');
        $output->write($result);
    }
}