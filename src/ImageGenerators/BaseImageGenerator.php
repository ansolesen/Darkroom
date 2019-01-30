<?php

/**
 *  ImageGenerator
 */

namespace Dresing\Darkroom\ImageGenerators;

use Dresing\Darkroom\ImageGenerators\ImageGenerator;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Intervention\Image\Facades\Image;


class BaseImageGenerator implements ImageGenerator
{


    public function toEncodedImage(string $fileContent, string $mime, string $templateClass) : \Intervention\Image\Image
    {

        switch ($mime) {
            case "image/jpeg":
                return $this->fromImage($fileContent, $templateClass);
                break;
            case "image/png":
                return $this->fromImage($fileContent, $templateClass);
                break;
            case "image/gif":
                return $this->fromImage($fileContent, $templateClass);
                break;
            default:
                return $this->handleUnknownFormat($fileContent, $templateClass);
        }
    }

    private function fromImage(string $fileContent, string $templateClass) : \Intervention\Image\Image
    {
        try {
            return Image::make($fileContent)->filter(new $templateClass());
        }catch(\Exception $e){
            return $this->handleUnknownFormat($fileContent, $templateClass);
        }
    }

    private function handleUnknownFormat(string $fileContent, string $templateClass)
    {
        return (new $templateClass())->drawFallback($fileContent);
    }

}
?>
