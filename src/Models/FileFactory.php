<?php

namespace Dresing\Darkroom\Models;

use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\StoredFile;
use Dresing\Darkroom\Models\UploadFile;
use Illuminate\Http\UploadedFile;

class FileFactory
{
    public static function createFromUpload(UploadedFile $upload) : UploadFile
    {
        $file = new UploadFile();
        return $file->setName($upload->getClientOriginalName())
        ->setMime($upload->getMimeType())
        ->setContent($upload->get())
        ->setSource($upload)
        ->setRawFileName((uniqid(rand()) . uniqid()));
    }

    public static function createFromRaw(string $content, $mime) : UploadFile
    {
        $file = new UploadFile();
        return $file->setName('')
        ->setMime($mime)
        ->setContent($content)
        ->setSource($content)
        ->setRawFileName((uniqid(rand()) . uniqid()));
    }

    public static function createFromStorage(string $name, FileManager $fileManager) : StoredFile
    {
        $file = new StoredFile();
        return $file->setMime($fileManager->meta['files'][$name]['mime'])
            ->setUrl($fileManager->getUrl($fileManager->meta['files'][$name]['path']))
            ->setImages(
                collect($fileManager->meta['files'][$name]['images'])->map(function($img) use($fileManager, $name){
                    return $fileManager->getUrl($img['path']);
                })->toArray()
            )
            ->setVisibility($fileManager->meta['files'][$name]['visibility'])
            ->setPath($fileManager->meta['files'][$name]['path'])
            ->setRawFileName($name)
            ->setFileManager($fileManager);
    }
}

