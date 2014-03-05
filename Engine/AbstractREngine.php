<?php
namespace Kachkaev\RBundle\Engine;
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
        $output = $rProcess->getAllOutput();
        unset($rProcess);

        return $output;
    }

    public function createInteractiveProcess()
    {
        return $this->createProcess();
    }
}
