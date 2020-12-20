<?php

class S3Exception extends Exception {
    function __construct($message, $file, $line, $code = 0)
    {
        parent::__construct($message, $code);
        $this->file = $file;
        $this->line = $line;
    }
}