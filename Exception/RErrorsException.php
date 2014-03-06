<?php
namespace Kachkaev\RBundle\Exception;
class RErrorsException extends RException
{
    private $inputLog;
    private $outputLog;
    private $errors;

    public function __construct($inputLog, $outputLog, $errors)
    {
        $this->inputLog = $inputLog;
        $this->outputLog = $outputLog;
        $this->errors = $errors;

        $errorCount = count($errors);
        $message = $errorCount == 1 ? 'One error occurred when running R script'
                : sprintf('%d errors occurred when running R script',
                        $errorCount);

        parent::__construct($message, 0, null);
    }

    public function getInputLog()
    {
        return $this->inputLog;
    }

    public function getOutputLog()
    {
        return $this->outputLog;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
