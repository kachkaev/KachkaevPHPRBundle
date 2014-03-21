<?php
namespace Kachkaev\RBundle\Engine;
use Kachkaev\RBundle\Exception\RErrorsException;

use Kachkaev\RBundle\Exception\RProcessException;

use Kachkaev\RBundle\Process\RProcessInterface;

abstract class AbstractREngine implements REngineInterface
{
    /**
     * @return RProcessInterface
     */
    abstract protected function createProcess();

    /**
     * (non-PHPdoc)
     * @see \Kachkaev\RBundle\Engine\REngineInterface::run()
     */
    public function run($rCode, $resultAsArray = false, $isErrorSensitive = false)
    {
        $rProcess = $this->createInteractiveProcess($isErrorSensitive);
        $rProcess->start();
        try {
            $rProcess->write($rCode);
            $errorsException = null;
        } catch (RErrorsException $e) {
            $errorsException = $e; 
        }
        $rProcess->stop();

        $result = $rProcess->getAllResult($resultAsArray);
        unset($rProcess);
        
        if ($errorsException) {
            throw $errorsException;
        }

        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see \Kachkaev\RBundle\Engine\REngineInterface::createInteractiveProcess()
     */
    public function createInteractiveProcess($isErrorSensitive = false)
    {
        $rProcess = $this->createProcess();
        if ($isErrorSensitive) {
            $rProcess->setErrorSensitive($isErrorSensitive);
        }
        
        return $rProcess;
    }
}
