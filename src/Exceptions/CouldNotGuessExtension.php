<?php

namespace Dresing\Darkroom\Exceptions;

use Exception;

class CouldNotGuessExtension extends Exception
{
    protected $message = 'The file mime was not recognized';
}
