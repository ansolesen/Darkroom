<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    |
    */

    'disk_name' => 'local',

    // Use custom implementations
    'path_generator' => Dresing\Darkroom\PathGenerator\BasePathGenerator::class,
    'file_manager' => Dresing\Darkroom\FileManagers\BaseFileManager::class,
    'image_generator' => Dresing\Darkroom\ImageGenerators\BaseImageGenerator::class,
    'compressor' => Dresing\Darkroom\Compressors\BaseCompressor::class,




];
