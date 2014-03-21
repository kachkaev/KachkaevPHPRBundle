<?php
namespace Kachkaev\RBundle;
use Kachkaev\RBundle\Engine\REngineInterface;
use Kachkaev\RBundle\Process\RProcessInterface;

class RCore
{
    private $rEngine;
    
    public function __construct(REngineInterface $rEngine)
    {
        $this->rEngine = $rEngine;
    }
    
    public function run($rCode, $resultAsArray = false, $isErrorSensitive = false)
    {
        return $this->rEngine->run($rCode, $resultAsArray);
    }
    
    public function createInteractiveProcess($isErrorSensitive = false)
    {
        return $this->rEngine->createInteractiveProcess($isErrorSensitive);
    }
}
