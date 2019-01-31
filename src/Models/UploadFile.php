<?php

/**
 * File
 */

namespace Dresing\Darkroom\Models;

use Dresing\Darkroom\Exceptions\CouldNotGuessExtension;
use Dresing\Darkroom\ImageGenerators\ImageGenerator;
use Dresing\Darkroom\Models\File;
use Dresing\Darkroom\Templates\Template;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class UploadFile extends File
{

    public $name;
    public $mime;
    public $content;
    public $source;


    public function setMime(string $mime) : self
    {
        $this->mime = $mime;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }
    public function setRawFileName(string $rawFileName)
    {
        $this->rawFileName = $rawFileName;
        return $this;
    }







}

?>
