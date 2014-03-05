<?php
namespace Kachkaev\RBundle\Engine;

use Kachkaev\RBundle\Process\CommandLineRProcess;

class CommandLineREngine extends AbstractREngine
{
    private $rCommand;
    
    public function __construct($rCommand) {
        $this->rCommand = $rCommand;
    }
    
    protected function createProcess() {
        return new CommandLineRProcess($this->rCommand);
    }
}