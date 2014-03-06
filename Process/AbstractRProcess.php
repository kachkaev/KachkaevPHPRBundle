<?php
namespace Kachkaev\RBundle\Process;
use Kachkaev\RBundle\Exception\RProcessException;

abstract class AbstractRProcess implements RProcessInterface
{
    protected $inputLineCount = 0;
    protected $inputLog = [];
    protected $outputLog = [];
    protected $errors = [];
    protected $lastWriteCommandCount = 0;
    protected $lastWriteErrorCount = 0;
    protected $active = false;

    protected abstract function doStart();
    protected abstract function doStop();
    protected abstract function doWrite(array $rInputLines);

    public function start()
    {
        $this->mustBeStopped();
        $this->inputLineCount = 0;
        $this->inputLog = [];
        $this->outputLog = [];
        $this->errors = [];
        $this->lastWriteCommandCount = 0;
        $this->lastWriteErrorCount = 0;

        $this->doStart();
        $this->active = true;
    }

    public function stop()
    {
        $this->mustBeStarted();
        $this->doStop();
        $this->active = false;
    }

    public function isStarted()
    {
        return !$this->active;
    }

    public function isStopped()
    {
        return !$this->active;
    }

    public function write($rInput)
    {
        if (!is_string($rInput)) {
            throw new \InvalidArgumentException(
                    sprintf("R input must be a string, %s given",
                            var_export($rInput, true)));
        }

        $this->mustBeStarted();
        
        $this->lastWriteCommandCount = 0;
        $this->lastWriteErrorCount = 0;
        
        try {
            $rInputLines = explode("\n", $rInput);
            $this->doWrite($rInputLines);
        } catch (Exception $e) {
            try {
                $this->stop();
            } catch (Exception $e) {
            }
            throw $e;
        }
        return $this->getLastWriteErrorCount();
    }

    public function getAllInput($asArray = false)
    {
        return $asArray ? $this->inputLog : implode("\n", $this->inputLog);
    }

    public function getAllOutput($asArray = false)
    {
        return $asArray ? $this->outputLog : implode("\n", $this->outputLog);
    }

    public function getLastWriteInput($asArray = false)
    {
        $lastWriteInput = array_slice($this->inputLog,
                -$this->lastWriteCommandCount, $this->lastWriteCommandCount);
        return $asArray ? $lastWriteInput : implode("\n", $lastWriteInput);
    }

    public function getLastWriteOutput($asArray = false)
    {
        $lastWriteOutput = array_slice($this->outputLog,
                -$this->lastWriteCommandCount, $this->lastWriteCommandCount);
        return $asArray ? $lastWriteOutput : implode("\n", $lastWriteOutput);
    }

    public function hasErrors()
    {
        return count($this->errors) != 0;
    }

    public function getErrorCount()
    {
        return count($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasLastWriteErrors()
    {
        return $this->lastWriteErrorCount != 0;
    }

    public function getLastWriteErrorCount()
    {
        return $this->lastWriteErrorCount;
    }

    public function getLastWriteErrors()
    {
        $lastWriteErrors = array_slice($this->errors,
                -$this->lastWriteErrorCount, $this->lastWriteErrorCount);
        return $lastWriteErrors;

    }

    private function mustBeStarted()
    {
        if (!$this->active) {
            throw new RProcessException(
                    'R process is stopped, it must be started');
        }
    }

    private function mustBeStopped()
    {
        if ($this->active) {
            throw new RProcessException(
                    'R process has been started, it must be stopped');
        }
    }
}
