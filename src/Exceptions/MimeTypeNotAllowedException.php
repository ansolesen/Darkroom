<?php

namespace Dresing\Darkroom\Exceptions;

use Exception;

class MimeTypeNotAllowedException extends Exception
{
    protected $message = 'The file type is not allowed';
}
