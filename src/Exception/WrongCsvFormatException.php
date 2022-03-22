<?php

namespace OlegSv\TableReader\Exception;

class WrongCsvFormatException extends \Exception
{
    public function __construct(array $rowData)
    {
        $this->message = 'Wrong csv format in row: ' . json_encode($rowData);
    }
}
