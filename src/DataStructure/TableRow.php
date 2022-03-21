<?php

namespace OlegSv\TableReader\DataStructure;

class TableRow
{
    private array $cells = [];

    public function addCell(TableCell $cell): void
    {
        $this->cells[] = $cell;
    }

    public function getCells(): array
    {
        return $this->cells;
    }

    public static function createFromArray(array $rowArray): self
    {
        $row = new self();
        foreach ($rowArray as $key => $value) {
            $cell = new TableCell($key, $value);
            $row->addCell($cell);
        }

        return $row;
    }
}
