<?php

namespace Innowise\app\Models;

class FileModel
{
    public string $size;
    public string $type;
    public string $name;

    public function __construct(string $name, string $size, string $type)
    {
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
    }
}
