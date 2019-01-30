<?php

/**
 * File
 */

namespace Dresing\Darkroom\Models;

use Dresing\Darkroom\Exceptions\CouldNotGuessExtension;
use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\File;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

abstract class File
{
    protected $fileManager;
    protected $mime;
    protected $rawFileName;
    protected $visibility = 'private';


    public function setFileManager(FileManager $fileManager) : File
    {
        $this->fileManager = $fileManager;
        return $this;
    }

    public function setVisibility(string $visibility) : self
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }
    public function getMime()
    {
        return $this->mime;
    }

    public function getExtention()
    {
        $guesser = ExtensionGuesser::getInstance();
        return $guesser->guess($this->mime);
    }

    public function getPath()
    {
        return $this->fileManager->pathGenerator->getPath() . "/{$this->fullFileName()}";
    }

    public function fullFileName()
    {
        $extension = $this->getExtention();
        if(!$extension)
        {
            throw new CouldNotGuessExtension();
        }
        return "{$this->getRawFileName()}.{$extension}";
    }

    public function getRawFileName() : string
    {
        return $this->rawFileName;
    }

    public function store(FileCollection $fileCollection)
    {
        if($fileCollection->forSingleFile())
        {
            $this->fileManager->clean();
        }
        $this->fileManager->insertFile($this, $fileCollection->images);
    }

}

?>
