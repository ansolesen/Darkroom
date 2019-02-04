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
use Dresing\Darkroom\Templates\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class CreateRequest extends Request
{
    public $file;
    public $visibility;


    public function createFromUpload(UploadedFile $file, string $visibility = '') : self
    {
        $this->file = FileFactory::createFromUpload($file);
        $this->visibility = $visibility;
        return $this;
    }

    public function createFromUrl($url, string $visibility = '') : self
    {
        $content = file_get_contents($url);
        return $this->createFromRaw();
    }
    public function createFromRaw(string $content, string $visibility = '') : self
    {
        $file_info = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $file_info->buffer($content);
        $this->file = FileFactory::createFromRaw($content, $mime);
        $this->visibility = $visibility;
        return $this;
    }
    /**
     * Insert the file into a collection.
     * @param  string $collectionName [description]
     * @return [type]                 [description]
     */
    public function to(string $collectionName = '')
    {
        $fileCollection = $this->findFileCollection($collectionName);

        $pathGenerator = app(PathGenerator::class)->load($this->model, $fileCollection);

        if(!$fileCollection->mimeTypeAllowed($this->file->mime))
        {
            throw new MimeTypeNotAllowedException();
        }


        $selectedDisk = $fileCollection->disk ? $fileCollection->disk : $this->disk;

        $visibility = $this->visibility ? $this->visibility : $fileCollection->getVisibility();

        $fileManager = app(FileManager::class)->load($selectedDisk, $pathGenerator);

        $this->file
        ->setFileManager($fileManager)
        ->setVisibility($visibility)
        ->store($fileCollection);

    }







}

?>
