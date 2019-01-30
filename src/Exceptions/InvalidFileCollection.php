<?php

namespace Dresing\Darkroom\Exceptions;

use Exception;

class InvalidFileCollection extends Exception
{

    public static function notFound(string $name)
    {
        return new static("FileCollection '{$name}'  not found.");
    }
}
