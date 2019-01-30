<?php
namespace Dresing\Darkroom\FileManagers;

use Dresing\Darkroom\FileCollection\FileCollection;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\Models\File;
use Dresing\Darkroom\Models\UploadFile;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface FileManager
{
    // Will either load a meta file or create a new one
    public function load(string $disk, PathGenerator $pathGenerator) : FileManager;

    // Will either set or update a meta property

    // Store a new File and updates meta
    public function insertFile(File $file, array $images) : FileManager;

    //Will remove a file
    public function removeFile(string $name);

    // Load a file from the filesystem
    public function getFile(string $name);

    // Clean the folder (remove everything)
    public function clean();

    public function save() : FileManager;

    // A list of all files
    public function list() : Collection;

    public function getUrl(string $filename) : string;

}
