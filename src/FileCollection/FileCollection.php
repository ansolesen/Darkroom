<?php

namespace Dresing\Darkroom\FileCollection;

use Dresing\Darkroom\FileManagers\FileManager;
use Illuminate\Support\Arr;


/**
 * FileCollection
 */
class FileCollection
{

    public $name;
    public $disk;
    public $singleFile;
    public $mimes;
    public $images;
    public $visibility;

    function __construct(string $name)
    {
        $this->name = $name;
        $this->mimes = [];
        $this->singleFile = false;
        $this->images = [];
        $this->visibility = 'private';
    }

    public function getImageHash()
    {
        $hash = '';
        foreach($this->images as $name => $class)
        {
            $hash = $hash .  md5($name . md5_file((new \ReflectionClass($class))->getFileName()));
        }
        return $hash;
    }

    public function isPublic() : self
    {
        $this->visibility = 'public';
        return $this;
    }

    public function isPrivate() : self
    {
        $this->visibility = 'private';
        return $this;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function disk(string $name) : self
    {
        $this->disk = $name;
        return $this;
    }

    public function single() : self
    {
        $this->singleFile = true;
        return $this;
    }

    public function images(array $images) : self
    {
        $this->images = $images;
        return $this;
    }

    public function allowMimes($mimes) : self
    {
        $this->mimes = Arr::wrap($mimes);
        return $this;
    }

    public static function makeDefault()
    {
        return new static('default');
    }

    public function forSingleFile()
    {
        return $this->singleFile;
    }

    public function getMimes()
    {
        return $this->mimes;
    }

    public function mimeTypeAllowed(string $mimeType)
    {
        return !count($this->getMimes()) || in_array($mimeType, $this->getMimes());
    }


}
?>
