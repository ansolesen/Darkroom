<?php

namespace Dresing\Darkroom\Traits;

use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\Requests\CreateRequest;
use Dresing\Darkroom\Requests\DeleteRequest;
use Dresing\Darkroom\Requests\GetRequest;
use Illuminate\Http\UploadedFile;

trait HasAttachments{

    public static $attacherClass;

    public function attachFromUpload(UploadedFile $file, string $visibility = '')
    {
        return app(CreateRequest::class)->setModel($this)->createFromUpload($file, $visibility);
    }

    public function attachFromRaw($content, string $visibility = '')
    {
        return app(CreateRequest::class)->setModel($this)->createFromUpload($file, $visibility);
    }

    public function attachFromUrl($url, string $visibility = '')
    {
        return app(CreateRequest::class)->setModel($this)->createFromUrl($url, $visibility);
    }

    public function getAttachments(string $fileCollectionName, $disk = '')
    {
        return app(GetRequest::class)->setModel($this)->getAttachments($fileCollectionName, $disk);
    }

    public function getFirstAttachment(string $fileCollectionName, $disk = '')
    {
        return app(GetRequest::class)->setModel($this)->getFirstAttachment($fileCollectionName, $disk);
    }
    public function getLatestAttachment(string $fileCollectionName, $disk = '')
    {
        return app(GetRequest::class)->setModel($this)->getFirstAttachment($fileCollectionName, $disk);
    }
    public static function useAttacher($attacherClass)
    {
        static::deleting(function($model){
            return app(DeleteRequest::class)->setModel($model)->deleteEverything();
        });

        self::$attacherClass = $attacherClass;
    }



    /**
     * Must be implemented by the model.
     *
     * @return [type] [description]
     */
    public function registerFileCollections()
    {

    }


}

?>
