<?php
namespace Kachkaev\RBundle\Process;
use Kachkaev\RBundle\Exception\RProcessException;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

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
        $pb->add('--no-save');
        $pb->setTimeout(null);

        $this->process = $pb->getProcess();
        $this->process->run();
        
        var_dump($this->process->getIncrementalOutput());
        var_dump($this->process->getIncrementalOutput());
        var_dump('=============');
        
        $errorOutput = $this->process->getIncrementalErrorOutput();
        if ($errorOutput) {
            throw new RProcessException($errorOutput);
        }
    }

    function doStop()
    {
        $this->process->stop();
    }

    function doWrite(array $rInputLines)
    {
        $initialCommandCount = count($this->outputLog);
        $initialLineCount = $this->inputLineCount;

        $currentCommandCount = 0;
        $currentLineCount = 0;
        
        foreach ($rInputLines as $rInputLine) {
            ++$currentLineCount;
            var_dump($rInputLine);
            $this->process->setStdin($rInputLine + "\n");
            $this->process->start();
            $this->process->wait();
            
            var_dump($this->process->getIncrementalOutput());
            var_dump($this->process->getIncrementalOutput());
        }
    }

}
