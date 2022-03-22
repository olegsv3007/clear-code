<?php

namespace OlegSv\TableReader\Exception;

class FileNotFoundException extends \Exception
{
    public function __construct(string $fileSrc)
    {
        $this->message = 'File not found in ' . $fileSrc;
    }
}
