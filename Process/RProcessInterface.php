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
     * Writes lines of commands to R interpreter
     * 
     * @param string $input a multi-line string with commands to execute 
     * @return array input split into commands (one command per element)
     *
     * @throws RProcessException if the given input does not form a complete 
     *                 command (e.g. "1 + ("), which makes R waiting
     *                 for the rest of the multi-line command.
     *                 Such case is fatal and stops the process.
     * //@throws RErrorException if there's error in the input (R could not process it)
     * //            or if the given input does not form a complete command (e.g. "1 + ("),
     * //            which makes R waiting for the rest of the multi-line command
     */
    public function write($input);
    
    /**
     * Returns the output from the R interpreter (only what has not been read yet)
     * 
     * @param string $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the output is split by input commands)
     * @return string|array the output from R that has not been read yet
     */
    public function read($asArray = false);
    
    /**
     * Returns all input to the R interpreter
     * 
     * @param string $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the input is split by commands)
     * @return string|array all input to R
     */
    public function getAllInput($asArray = false);
    
    /**
     * Returns all output from the R interpreter
     * 
     * @param string $asArray if set to true, an array of strings is returned instead of a single string
     *                 (the output is split by input commands)
     * @return string|array all output from R
     */
    public function getAllOutput($asArray = false);

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
