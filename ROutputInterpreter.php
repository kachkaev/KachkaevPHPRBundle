<?php
namespace Kachkaev\RBundle;

class ROutputInterpreter
{
    /**
     * "[1] 42"
     *  ↓
     *  42
     * 
     * @param string $output
     * 
     * @return numeric
     */
    public function singleNumber($output) {
        return (float) substr($output, 4);
    }
}
