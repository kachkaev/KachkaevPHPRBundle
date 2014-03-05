<?php
namespace Kachkaev\RBundle;
use Kachkaev\RBundle\Engine\REngineInterface;
use Kachkaev\RBundle\Process\RProcessInterface;

class R
{
    private $rEngine;
    
    public function __construct(REngineInterface $rEngine)
    {
        $this->rEngine = $rEngine;
    }
    
    public function run($rCode)
    {
        return $this->rEngine->run($rCode);
    }
    
    public function startInteractiveProcess()
    {
        $rProcess = $this->rEngine->createInteractiveProcess();
        $rProcess->start();
        return $rProcess;
    }
}
