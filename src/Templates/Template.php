<?php

namespace Dresing\Darkroom\Templates;

use Intervention\Image\Filters\FilterInterface;

interface Template extends FilterInterface
{
    public function drawFallback(string $fileContent);
}
