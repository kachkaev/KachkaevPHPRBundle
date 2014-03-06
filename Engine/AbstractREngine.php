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
    public function run($rCode)
    {
        $rProcess = $this->createProcess();
        $rProcess->start();
        $rProcess->write($rCode);
        $rProcess->stop();

        $exception = null;
        if ($rProcess->hasErrors()) {
            $exception = new RErrorsException($rProcess->getAllInput(true), $rProcess->getAllOutput(true), $rProcess->getErrors());
        } else {
            $output = $rProcess->getAllOutput();
        }
        unset($rProcess);

        if ($exception) {
            throw $exception;
        } else {
            return $output;
        }
    }

    public function createInteractiveProcess()
    {
        return $this->createProcess();
    }
}
