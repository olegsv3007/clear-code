<?php

namespace OlegSv\TableReader\Service;

class Stream
{
    /** @var resource|false */
    private $resource;

    /**
     * @param resource|false $stream
     */
    public static function create($resource): self
    {
        $newStream = new self();
        $newStream->resource = $resource;

        return $newStream;
    }

    /**
     * @return resource|false
     */
    public function get()
    {
        return $this->resource;
    }

    public function close(): void
    {
        if (is_resource($this->resource)) {
            fclose($this->resource);
        }
    }
}