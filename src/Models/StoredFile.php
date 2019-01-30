<?php

/**
 * File
 */

namespace Dresing\Darkroom\Models;

use Dresing\Darkroom\Exceptions\CouldNotGuessExtension;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\File;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class StoredFile extends File
{
    protected $path;
    public $url;
    public $images = [];


    public function setUrl($url) : self
    {
        $this->url = $url;
        return $this;
    }

    public function setImages(array $images) : self
    {
        $this->images = $images;
        return $this;
    }

    public function setMime(string $mime) : self
    {
        $this->mime = $mime;
        return $this;
    }
    public function setRawFileName(string $rawFileName)
    {
        $this->rawFileName = $rawFileName;
        return $this;
    }
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }


}

?>
