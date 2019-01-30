<?php

namespace Dresing\Darkroom\Attachers;

use Dresing\Darkroom\FileCollection\FileCollection;

abstract class Attacher
{
    private $fileCollections;

    function __construct()
    {
        $this->fileCollections = [];
    }

    /**
     * Register all attachments for the given model
     * @return [void] [description]
     */
    abstract public function register();

    public function addFileCollection(string $name) : FileCollection
    {
        $fileCollection = new FileCollection($name);
        $this->fileCollections[] = $fileCollection;
        return $fileCollection;
    }

    public function getFileCollections()
    {
        return $this->fileCollections;
    }

}
