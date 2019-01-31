<?php

namespace Dresing\Darkroom\Compressors;

use Dresing\Darkroom\Models\File;

interface Compressor
{
    public function compress(File $file) : File;
}
