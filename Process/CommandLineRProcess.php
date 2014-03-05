<?php
namespace Kachkaev\RBundle\Process;
use Symfony\Component\Process\ProcessBuilder;

use Symfony\Component\Process\Process;

class CommandLineRProcess extends AbstractRProcess
{
    private $rCommand;
    private $process;

    public function __construct($rCommand)
    {
        $this->rCommand = $rCommand;
    }

    function doStart()
    {
        $pb = new ProcessBuilder();
        $pb->add($this->rCommand);
        
        $this->process = $pb->getProcess();
        $this->process->start();
    }

    function doWrite()
    {
        //$this->process->is
    }

    function doStop()
    {
        $this->process->stop();
    }

    public function doIsPrompting()
    {
        return $this->process->isTerminated();
    }
}
