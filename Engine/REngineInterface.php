<?php
namespace Kachkaev\RBundle\Engine;
use Kachkaev\RBundle\Process\RProcessInterface;

interface REngineInterface
{
    public function run($rCode);

    /**
     * @return RProcessInterface
     */
    public function createInteractiveProcess();
}
