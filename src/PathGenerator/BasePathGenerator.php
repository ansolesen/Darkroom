<?php

namespace Dresing\Darkroom\PathGenerator;


use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Database\Eloquent\Model;

class BasePathGenerator implements PathGenerator
{
    public $model;
    public $fileCollection;

    public function load(Model $model, FileCollection $fileCollection) : PathGenerator
    {
        $this->model = $model;
        $this->fileCollection = $fileCollection;
        return $this;
    }

    public function getPath() : string
    {
        return implode('/', [$this->model->getTable(), $this->model->id, $this->fileCollection->name]);
    }
    public function getPathForImages() : string
    {
        return $this->getPath($this->model, $this->fileCollection) . '/images';
    }

    public function getMetaFilePath() : string
    {
        return $this->getPath($this->model, $this->fileCollection) . '/meta.json';
    }

    public function getFileCollection() : FileCollection
    {
        return $this->fileCollection;
    }

}
?>
