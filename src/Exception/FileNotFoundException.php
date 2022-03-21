<?php

namespace OlegSv\TableReader\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct(string $fileSrc)
    {
        parent::__construct();
        $this->message = 'File not found in ' . $fileSrc . PHP_EOL;
    }
}