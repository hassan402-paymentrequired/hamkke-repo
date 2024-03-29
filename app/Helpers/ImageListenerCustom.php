<?php

namespace App\Helpers;

use nadar\quill\Line;
use nadar\quill\listener\Image;

class ImageListenerCustom extends Image
{
    public $wrapper = '<img src="{src}" {width} {height} style="{styles}" alt="" class="img-responsive img-fluid" />';

    public function process(Line $line)
    {
        $embedUrl = $line->insertJsonKey('image');
        if ($embedUrl) {
            if ($width = $line->getAttribute('width')) {
                $width = 'width="'.$line->getLexer()->escape($width).'"';
            }

            if ($height = $line->getAttribute('height')) {
                $height = 'height="'.$line->getLexer()->escape($height).'"';
            }
            $styles = "";

            if ($float = $line->getAttribute('float')) {
                $floatDirection = $line->getLexer()->escape($float);
                $marginDirection = $floatDirection === 'left'? 'right': 'left';
                $styles .= 'float: '. $floatDirection .'; margin-' . $marginDirection . ': 0.5rem';
            }

            $this->updateInput($line, preg_replace('#\s+#', ' ', str_replace([
                '{src}',
                '{width}',
                '{height}',
                '{styles}'
            ], [
                $line->getLexer()->escape($embedUrl),
                $width,
                $height,
                $styles
            ], $this->wrapper)));
        }
    }
}
