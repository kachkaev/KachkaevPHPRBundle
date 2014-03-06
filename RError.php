<?php
namespace Kachkaev\RBundle;
class RError
{
    private $inputLineNumber;
    private $commandNumber;
    private $command;
    private $errorMessage;

    public function __construct($inputLineNumber, $commandNumber, $command, $errorMessage)
    {
        $this->inputLineNumber = $inputLineNumber;
        $this->commandNumber = $commandNumber;
        $this->command = $command;
        $this->errorMessage = $errorMessage;
    }

    public function getInputLineNumber()
    {
        return $this->inputLineNumber;
    }

    public function getCommandNumber()
    {
        return $this->commandNumber;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
