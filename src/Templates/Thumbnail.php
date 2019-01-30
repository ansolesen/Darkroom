<?php

namespace Dresing\Darkroom\Filters;

use Dresing\Darkroom\Templates\Template;
use Intervention\Image\Image;



class Thumbnail implements Template
{

    private $size = 300;
    private $quality = 90;

    public function applyFilter(Image $image)
    {
        return $image->fit($this->size, $this->size)
        ->encode('jpeg', $this->quality);
    }

    public function drawFallback($fileContent)
    {
        return \Intervention\Image\Facades\Image::canvas($this->size, $this->size, $this->generateMaterialColor($fileContent))->encode('jpeg', $this->quality);
    }

    private function generateMaterialColor($fileContent)
    {
        $arr = [
            '#ff1744',
            '#f50057',
            '#d500f9',
            '#651fff',
            '#3d5afe',
            '#2979ff',
            '#00b0ff',
            '#00e5ff',
            '#1de9b6',
            '#00e676',
            '#76ff03',
            '#c6ff00',
            '#ffea00',
            '#ffc400',
            '#ff9100',
            '#ff3d00',
        ];

        return $arr[crc32($fileContent) % count($arr)];
    }
}

?>
