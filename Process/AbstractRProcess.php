<?php
namespace Kachkaev\RBundle\Process;
use Kachkaev\RBundle\Exception\RProcessException;

abstract class AbstractRProcess implements RProcessInterface
{
    protected $inputLog = [];
    protected $outputLog = [];
    protected $unreadOutputCount = [];
    protected $errors = [];
    protected $lastWriteErrorCount = [];
    protected $running = false;

    protected abstract function doStart();
    protected abstract function doStop();
    protected abstract function doWrite();

    public function start()
    {
        $this->mustNotBeRunning();
        $this->doStart();
        $this->running = true;
    }
    
    public function read($asArray = false)
    {
        $lastOutputBuffer = $this->outputBuffer;
        $outputLog = array_merge($lastUnreadOutput, $lastOutputBuffer);
        $this->outputBuffer = [];
        return implode("\n", $lastOutputBuffer);
    }

    public function write($s)
    {
        $this->mustBeRunning();
        try {
            $writtenCommands = $this->doWrite($s); 
        } catch (Exception $e) {
            try {
                $this->stop();
            } catch (Exception $e) {
            }
            throw $e;
        }
        return $writtenCommands;
    }

    public function getAllOutput($asArray = false)
    {
        return $asArray ? $this->outputLog : implode("\n", $this->outputLog); 
    }

    public function getAllInput($asArray = false)
    {
        return $asArray ? $this->inputLog : implode("\n", $this->inputLog); 
    }

    public function stop()
    {
        $this->mustBeRunning();
        $this->doStop();
        $this->started = false;
    }

    public function isStopped()
    {
        return !$this->running;
    }
    
    private function mustBeStarted()
    {
        if (!$this->running) {
            throw new RProcessException('R process is stopped, it must be started');
        }
    }
    
    private function mustBeStopped()
    {
        if ($this->running) {
            throw new RProcessException('R process is running, it must be stopped');
        }
    }
}
