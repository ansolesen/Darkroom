<?php
namespace Dresing\Darkroom\Requests;

use Dresing\Darkroom\Exceptions\MimeTypeNotAllowedException;
use Dresing\Darkroom\Exceptions\NoAttacherFound;
use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\File;
use Dresing\Darkroom\Models\FileFactory;
use Dresing\Darkroom\Models\UploadFile;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Dresing\Darkroom\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class DeleteRequest extends Request
{

    public function deleteEverything()
    {
        foreach($this->getFileCollections() as $fileCollection)
        {
            $this->deleteFileCollection($fileCollection);
        }
    }

    public function deleteFileCollection(FileCollection $fileCollection)
    {
        $pathGenerator = app(PathGenerator::class)->load($this->model, $fileCollection);
        $selectedDisk = $fileCollection->disk ? $fileCollection->disk : $this->disk;
        app(FileManager::class)->load($selectedDisk, $pathGenerator)->clean();
    }

}

?>
