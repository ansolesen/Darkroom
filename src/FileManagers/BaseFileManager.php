<?php

namespace Dresing\Darkroom\FileManagers;

use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\ImageGenerators\ImageGenerator;
use Dresing\Darkroom\Models\File;
use Dresing\Darkroom\Models\UploadFile;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Http\File as LaravelFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;



class BaseFileManager implements FileManager
{
    public $disk;
    public $pathGenerator;
    public $meta;
    public $imageMap;

    public function load(string $disk, PathGenerator $pathGenerator) : FileManager
    {
        $this->disk = $disk;
        $this->pathGenerator = $pathGenerator;
        $this->meta = $this->cleanMetaFile();

        if(Storage::disk($this->disk)->exists($this->pathGenerator->getMetaFilePath()))
        {
            $this->meta =  json_decode(Storage::disk($this->disk)->get($this->pathGenerator->getMetaFilePath()), true);
        }
        return $this;
    }

    public function save() : FileManager
    {
        Storage::disk($this->disk)->put($this->pathGenerator->getMetaFilePath(), json_encode($this->meta), 'private');
        return $this;
    }


    public function insertFile(File $file, array $imageMap) : FileManager
    {
        $filePath = $file->getPath();
        Storage::disk($this->disk)->put($filePath, $file->content, $file->getVisibility());


        $rawFileName = $file->getRawFileName();

        $freshId = (int) array_get($this->meta, "count") + 1;
        array_set($this->meta, "count", $freshId);
        array_set($this->meta, "files.{$rawFileName}", []);
        array_set($this->meta, "files.{$rawFileName}.id", $freshId);
        array_set($this->meta, "files.{$rawFileName}.hash", $this->pathGenerator->getFileCollection()->getImageHash());
        array_set($this->meta, "files.{$rawFileName}.path", $filePath);
        array_set($this->meta, "files.{$rawFileName}.visibility", $file->getVisibility());
        array_set($this->meta, "files.{$rawFileName}.mime", $file->getMime());
        array_set($this->meta, "files.{$rawFileName}.images",  []);

        return $this->insertImages($imageMap, $rawFileName, $file)->save();

    }

    private function insertImages(array $imageMap, $fileName, UploadFile $file) : FileManager
    {
        $imageGenerator = app(ImageGenerator::class);

        foreach($imageMap as $collectionName => $class)
        {

            $image = $imageGenerator->toEncodedImage($file->content, array_get($this->meta, "files.{$fileName}.mime"), $class);
            $guesser = ExtensionGuesser::getInstance();
            $format = $guesser->guess($image->mime);
            $imagePath = $this->pathGenerator->getPathForImages() . "/{$collectionName}/{$fileName}.{$format}";
            Storage::disk($this->disk)->put($imagePath , $image->__toString(), 'public');
            array_set($this->meta, "files.{$fileName}.images.{$collectionName}", []);
            array_set($this->meta, "files.{$fileName}.images.{$collectionName}", [
                'path' => $imagePath
            ]);
        }
        return $this;
    }

    public function removeFile(string $name)
    {
        throw new \Exception('Method removeFile() is not implemented.');
    }

    public function getFile(string $name)
    {
        throw new \Exception('Method getFile() is not implemented.');
    }

    public function clean()
    {
        $files = Storage::disk($this->disk)->files($this->pathGenerator->getPath());

        if(count($files))
        {
            Storage::disk($this->disk)->deleteDirectory($this->pathGenerator->getPath());
        }
        $this->meta = $this->cleanMetaFile();
        return $this;
    }

    private function cleanMetaFile() : array
    {
        return [
            'count' => 0,
            'files' => []
        ];
    }

    public function list() : Collection
    {
        return collect($this->meta['files']);
    }

    public function getUrl(string $path) : string
    {
        return Storage::disk($this->disk)->url($path);
    }
}
