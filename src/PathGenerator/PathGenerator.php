<?php

namespace Dresing\Darkroom\PathGenerator;


use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Database\Eloquent\Model;



interface PathGenerator
{
    public function load(Model $model, FileCollection $fileCollection) : PathGenerator;
    public function getPath() : string;
    public function getPathForImages() : string;
    public function getMetaFilePath() : string;
    public function getFileCollection() : FileCollection;
}

