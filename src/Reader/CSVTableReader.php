<?php

namespace OlegSv\TableReader\Reader;

use OlegSv\TableReader\Contract\TableReader;
use OlegSv\TableReader\DataStructure\TableRow;
use OlegSv\TableReader\Exception\FileNotFoundException;
use OlegSv\TableReader\Exception\WrongCsvFormatException;

class CSVTableReader implements TableReader
{
    /** @var resource|false */
    private $fileHandler;
    private array $titles;

    public function __construct(string $fileSrc)
    {
        $this->openStream($fileSrc);
        $this->readTitles();
    }

    private function openStream(string $fileSrc)
    {
        if (file_exists($fileSrc)) {
            $this->fileHandler = fopen($fileSrc, 'r');
        } else {
            throw new FileNotFoundException($fileSrc);
        }
    }

    private function readTitles(): void
    {
        $this->titles = fgetcsv($this->fileHandler);
    }

    public function readNextRow(): TableRow|false
    {
        $rowData = fgetcsv($this->fileHandler);

        if ($rowData) {
            if ($this->isRowDataCountMathTitlesCount($rowData)) {
                $rowDataWithTitles = array_combine($this->titles, $rowData);

                return TableRow::createFromArray($rowDataWithTitles);
            }
            throw new WrongCsvFormatException($rowData);
        }

        fclose($this->fileHandler);
        return false;
    }

    private function isRowDataCountMathTitlesCount(array $rowData): bool
    {
        return count($this->titles) === count($rowData);
    }

    public function readChunk(int $size = self::DEFAULT_CHUNK_SIZE): array
    {
        $chunkRows = [];

        while (
            count($chunkRows) < $size
            && ($row = $this->readNextRow())
        ) {
            $chunkRows[] = $row;
        }

        return $chunkRows;
    }
}
