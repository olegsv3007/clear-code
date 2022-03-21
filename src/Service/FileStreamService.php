<?php

namespace OlegSv\TableReader\Service;

use OlegSv\TableReader\Exception\FileNotFoundException;

class FileStreamService
{
    /** @var resource|false */
    private $stream = false;
    private string $fileSrc;

    public function __construct(string $fileSrc)
    {
        $this->fileSrc = $fileSrc;
    }

    public function openStream(): void
    {
        if (file_exists($this->fileSrc)) {
            $this->stream = fopen($this->fileSrc, 'r');
        } else {
            throw new FileNotFoundException($this->fileSrc);
        }
    }

    /**
     * @return false|resource
     */
    public function getStream()
    {
        return is_resource($this->stream) ? $this->stream : false;
    }

    public function closeStream(): void
    {
        fclose($this->stream);
    }
}
