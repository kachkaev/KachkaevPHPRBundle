<?php
namespace Kachkaev\RBundle\Exception;
class RErrorsException extends RException
{
    private $inputLog;
    private $outputLog;
    private $errors;

    public function __construct(array $inputLog, array $outputLog, array $errors)
    {
        if (!count($errors)) {
            throw new \InvalidArgumentException('Argument $errors in constructor of RErrorsException must contain at least one error');
        }
        
        $this->inputLog = $inputLog;
        $this->outputLog = $outputLog;
        $this->errors = $errors;
        

        $errorCount = count($errors);
        $message = $errorCount == 1 ? 'One error occurred when running a chunk of R script: '
                : sprintf('%d errors occurred when running a chunk of R script. First: ',
                        $errorCount);
        
        $message .= $errors[0]->getErrorMessage();

        parent::__construct($message, 0, null);
    }

    /**
     * @return array
     */
    public function getInputLog()
    {
        return $this->inputLog;
    }

    /**
     * @return array
     */
    public function getOutputLog()
    {
        return $this->outputLog;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
