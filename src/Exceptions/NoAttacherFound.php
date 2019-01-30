<?php

namespace Dresing\Darkroom\Exceptions;

use Exception;

class NoAttacherFound extends Exception
{
    protected $message = 'To handle attachments you must specify an attacher';
}
