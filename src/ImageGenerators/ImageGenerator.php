<?php

namespace Dresing\Darkroom\ImageGenerators;

use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Http\UploadedFile;
interface ImageGenerator
{
    public function toEncodedImage(string $fileContent, string $mime, string $templateClass) : \Intervention\Image\Image;
}
