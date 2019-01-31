<?php

namespace Dresing\Darkroom\Compressors;

use Dresing\Darkroom\Compressors\Compressor;
use Dresing\Darkroom\Models\File;
use Intervention\Image\Facades\Image;

class BaseCompressor implements Compressor
{
    public static $imageCompression = 70;

    public function compress(File $file) : File
    {
        switch ($file->mime) {
            case "image/jpeg":
                return $this->interventionCompress($file, 'jpeg');
                break;
            case "image/png":
                return $this->interventionCompress($file, 'jpeg');
                break;
            case "image/gif":
                return $this->interventionCompress($file, 'jpeg');
                break;
            default:
                return $file;
        }
    }

    private function interventionCompress(File $file, $mime) : File
    {
        return $file->setContent(Image::make($file->content)->encode($mime, static::$imageCompression)->__toString());
    }
}
