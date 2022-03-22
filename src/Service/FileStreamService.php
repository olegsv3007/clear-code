<?php

namespace OlegSv\TableReader\Service;

use OlegSv\TableReader\Exception\FileNotFoundException;

class FileStreamService
{
    public function openStream(string $fileSrc): Stream
    {
        if (!file_exists($fileSrc)) {
            throw new FileNotFoundException($fileSrc);
        }

        $resource = fopen($fileSrc, 'r');

        return Stream::create($resource);
    }
}
