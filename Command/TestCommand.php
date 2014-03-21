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
            ->addArgument('example', null, null, '0');
        ;
        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch ($input->getArgument('example')) {
            case '0': 
                $example = <<<EOF
library(asd)
1+1 + (
1)
a=1+1;
Sys.sleep(0)
sss                        
                        

1+1
EOF;
            break;
            default:
                $example = $input->getArgument('example');
        };
        
        echo $example;
        echo "\n----------\n";
        
        $r = $this->getContainer()->get('kachkaev_r.r');
        $result = $r->run($example);
        var_dump($result);
    }
}