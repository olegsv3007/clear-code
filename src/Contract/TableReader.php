<?php

namespace OlegSv\TableReader\Contract;

use OlegSv\TableReader\DataStructure\TableRow;

interface TableReader
{
    public const DEFAULT_CHUNK_SIZE = 100;

    public function readNextRow(): TableRow|false;
    public function readChunk(int $size = self::DEFAULT_CHUNK_SIZE): array;
}
