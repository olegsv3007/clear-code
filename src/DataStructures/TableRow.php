<?php

namespace OlegSv\TableReader\DataStructures;

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
}