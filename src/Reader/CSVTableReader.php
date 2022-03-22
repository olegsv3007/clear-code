<?php

namespace OlegSv\TableReader\Reader;

use OlegSv\TableReader\DataStructure\TableRow;
use OlegSv\TableReader\Exception\WrongCsvFormatException;
use OlegSv\TableReader\Service\FileStreamService;

class CSVTableReader implements TableReader
{
    private FileStreamService $fileStreamService;
    private array $titles;

    public function __construct(FileStreamService $fileStreamService)
    {
        $this->fileStreamService = $fileStreamService;
        $this->fileStreamService->openStream();
        $this->readTitles();
    }

    private function readTitles(): void
    {
        $this->titles = fgetcsv($this->fileStreamService->getStream());
    }

    public function readNextRow(): TableRow|false
    {
        $rowData = fgetcsv($this->fileStreamService->getStream());

        if ($rowData) {
            if ($this->isRowDataCountMathTitlesCount($rowData)) {
                $rowDataWithTitles = array_combine($this->titles, $rowData);

                return TableRow::createFromArray($rowDataWithTitles);
            }
            throw new WrongCsvFormatException($rowData);
        }

        $this->fileStreamService->closeStream();
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
            && is_resource($this->fileStreamService->getStream())
            && ($row = $this->readNextRow())
        ) {
            $chunkRows[] = $row;
        }

        return $chunkRows;
    }
}
