<?php

namespace Dresing\Darkroom\Requests;

use Dresing\Darkroom\Exceptions\InvalidFileCollection;
use Dresing\Darkroom\Exceptions\NoAttacherFound;
use Dresing\Darkroom\FileCollection\FileCollection;
use Illuminate\Database\Eloquent\Model;

abstract class Request
{
    public $attacher;
    public $model;
    public $collectionName = 'default';

    function __construct($disk)
    {
        $this->disk = $disk;
    }

    public function setModel(Model $model) : self
    {
        $this->model = $model;
        $this->registerAttacher($model);
        return $this;
    }


    protected function registerAttacher(Model $model)
    {
        if(!get_class($model)::$attacherClass)
        {
            throw new NoAttacherFound();
        }
        $this->attacher = app()->make(get_class($model)::$attacherClass);
        $this->attacher->register();
    }

    protected function getFileCollections()
    {
        return $this->attacher->getFileCollections();
    }

    protected function findFileCollection($name) : FileCollection
    {
        $fileCollection = collect($this->attacher->getFileCollections())->first(function ($value, $key) use($name){
            return $value->name == $name;
        });

        if(!$fileCollection)
        {
            throw InvalidFileCollection::notFound($name);
        }

        return $fileCollection;
    }


}

?>
