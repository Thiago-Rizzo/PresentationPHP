<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class CNvPr extends Model
{
    public string $tag = 'p:cNvPr';

    public string $id = '';
    public string $name = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        $instance = new static($tag);

        $node = $instance->getElement($xmlReader, $element);
        if (!$node) {
            return null;
        }

        $instance->id = $node->getAttribute('id');
        $instance->name = $node->getAttribute('name');

        return $instance;
    }
}
