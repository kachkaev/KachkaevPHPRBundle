<?php
namespace Kachkaev\RBundle\Process;
use Kachkaev\RBundle\Exception\RProcessException;
use Kachkaev\RBundle\Exception\RErrorException;

interface RProcessInterface
{
    /**
     * Starts the R process and also resets errors, input and output
     * 
     * @throws RProcessException if the process has already been started
     */
    public function start();

    /**
     * Stops the R process
     * 
     * @throws RProcessException if the process has already been stopped or is not yet started
     */
    public function stop();

    /**
     * Checks if the R process has been started
     * @return boolean true if the process has been started, but not stopped; false otherwise
     */
    public function isStarted();

    /**
     * Checks if the R process has been stopped or not yet started
     * 
     * @return boolean true if the process has been stopped or not yet started; false otherwise
     */
    public function isStopped();

    /**
     * Writes lines of commands to R interpreter
     * 
     * @param string $rInput a multi-line string with commands to execute 
     * @return integer the number of errors during the execution (same as getLastWriteErrorCount())
     *
     * @throws RProcessException if the given input does not form a complete 
     *                 command (e.g. "1 + ("), which makes R waiting
     *                 for the rest of a multi-line command.
     *                 Such case is fatal; the process stops.
     */
    public function write($rInput);

    /**
     * Returns all input to the R interpreter
     * 
     * @param boolean $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the input is split by commands)
     * @return string|array all input to R
     */
    public function getAllInput($asArray = false);

    /**
     * Returns all output from the R interpreter
     * 
     * @param boolean $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the output is split by input commands)
     * @return string|array all output from R
     */
    public function getAllOutput($asArray = false);

    /**
     * Returns all input, output and errors (as text or array, depending on $asArray parameter)
     * 
     * As text:
     * --------
     * > input
     * output
     * > multi-line input line 1
     * + line 2
     * output
     * >
     * >
     * > a+b
     * Error:object 'a' not found
     *
     * 
     * As array:
     * ---------
     * ['input1', 'output1', 'Error1']
     * ['input2', 'output2', 'Error2']
     * 
     * @param boolean $asArray if set to true, the result is returned as an array
     * @return string|array result of R execution
     */
    public function getAllResult($asArray = false);

    /**
     * Returns the most recent input to the R interpreter (since the last call of write() method)
     * 
     * @param boolean $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the input is split by commands)
     * @return string|array all input to R
     */
    public function getLastWriteInput($asArray = false);

    /**
     * Returns the most recent output from the R interpreter (since the last call of write() method) 
     * 
     * @param boolean $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the output is split by input commands)
     * @return string|array all output from R
     */
    public function getLastWriteOutput($asArray = false);

    /**
     * Returns the most recent input, output and errors (since the last call of write() method)
     * 
     * For details on format see getAllResult()
     *
     * @param boolean $asArray if set to true, the result is returned as an array
     * @return string|array result of R execution
     */
    public function getLastWriteResult($asArray = false);
    
    /**
     * Determines if there were errors since the last call of start() method
     * 
     * @return boolean true if there were errors since the last call of start() method, false otherwise 
     */
    public function hasErrors();

    /**
     * Gets the number of errors that occurred since the last call of start() method
     * 
     * @return integer
     */
    public function getErrorCount();

    /**
     * Gets the array of errors (elements are of type RError) since the last call of start() method
     * 
     * @return array
     */
    public function getErrors();

    /**
     * Determines if there were errors since the last call of write() method
     * 
     * @return boolean true if there were errors since the last call of write() method, false otherwise 
     */
    public function hasLastWriteErrors();

    /**
     * Gets the number of errors that occurred since the last call of write() method
     * 
     * @return integer
     */
    public function getLastWriteErrorCount();

    /**
     * Gets the array of errors (elements are of type RError)
     * that occurred since the last call of write() method 
     * 
     * @return array
     */
    public function getLastWriteErrors();
}
