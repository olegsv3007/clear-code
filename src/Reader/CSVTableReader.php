<?php

namespace OlegSv\TableReader\Reader;

use OlegSv\TableReader\DataStructure\TableRow;
use OlegSv\TableReader\Exception\WrongCsvFormatException;
use OlegSv\TableReader\Service\Stream;

class CSVTableReader implements TableReader
{
    private Stream $stream;
    private array $titles;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
        $this->readTitles();
    }

    private function readTitles(): void
    {
        $this->titles = fgetcsv($this->stream->get());
    }

    public function readNextRow(): TableRow|false
    {
        $rowData = fgetcsv($this->stream->get());

        if ($rowData) {
            if ($this->isRowDataCountMathTitlesCount($rowData)) {
                $rowDataWithTitles = array_combine($this->titles, $rowData);

                return TableRow::createFromArray($rowDataWithTitles);
            }
            throw new WrongCsvFormatException($rowData);
        }

        $this->stream->close();
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
            && is_resource($this->stream->get())
            && ($row = $this->readNextRow())
        ) {
            $chunkRows[] = $row;
        }

        return $chunkRows;
    }
}
