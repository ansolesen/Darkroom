<?php
namespace Dresing\Darkroom\Requests;

use Dresing\Darkroom\Exceptions\MimeTypeNotAllowedException;
use Dresing\Darkroom\Exceptions\NoAttacherFound;
use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\FileManager\NameResolver;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\FileFactory;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class GetRequest extends Request
{

    public function getFirstAttachment($fileCollectionName, $disk = '')
    {
        return $this->getAttachments($fileCollectionName, $disk)->first();
    }

    public function getLatestAttachment($fileCollectionName, $disk = '')
    {
        return $this->getAttachments($fileCollectionName, $disk)->last();
    }

    public function getAttachments($fileCollectionName, $disk = '')
    {
        $fileCollection = $this->findFileCollection($fileCollectionName);
        $pathGenerator = app(PathGenerator::class)->load($this->model, $fileCollection);

        $selectedDisk = $disk ? $disk : $fileCollection->disk;
        $selectedDisk = $selectedDisk ? $selectedDisk : $this->disk;

        $fileManager = app(FileManager::class)->load($selectedDisk, $pathGenerator);

        $files = [];

        foreach ($fileManager->list() as $name => $meta)
        {
            $files[] = FileFactory::createFromStorage($name, $fileManager);
        }

        return collect($files);

    }


}

?>
