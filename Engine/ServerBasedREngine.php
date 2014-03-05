<?php
namespace Kachkaev\RBundle\Engine;

use Kachkaev\RBundle\Process\ServerBasedRProcess;

class ServerBasedREngine extends AbstractREngine
{
    private $serverURL;
    
    public function __construct($serverURL) {
        $this->serverURL = $serverURL;
    }
    
    protected function createProcess() {
        return new ServerBasedRProcess($this->serverURL);
    }
}