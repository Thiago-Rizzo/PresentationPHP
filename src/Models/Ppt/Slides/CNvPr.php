<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class CNvPr extends Model
{
    public string $id = '';
    public string $name = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'p:cNvPr') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('p:cNvPr', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->id = $node->getAttribute('id');
        $instance->name = $node->getAttribute('name');

        return $instance;
    }
}
