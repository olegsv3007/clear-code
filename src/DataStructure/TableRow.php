<?php

namespace OlegSv\TableReader\DataStructure;

class TableRow
{
    private array $fields = [];

    public function addField(TableCell $cell): void
    {
        $this->fields[] = $cell;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public static function createFromArray(array $rowArray): self
    {
        $row = new self();
        foreach ($rowArray as $key => $value) {
            $cell = new TableCell($key, $value);
            $row->addField($cell);
        }

        return $row;
    }
}
