<?php

namespace ThiagoRizzo\PresentationPHP\Models\Ppt\Slides;

use DOMElement;
use PhpOffice\Common\XMLReader;
use ThiagoRizzo\PresentationPHP\Models\Model;

class ChOff extends Model
{
    public string $x = '';
    public string $y = '';

    public static function load(XMLReader $xmlReader, DOMElement $element, ?string $tag = null): ?self
    {
        if ($element->nodeName == 'a:chOff') {
            $node = $element;
        } else {
            $node = $xmlReader->getElement('a:chOff', $element);
        }

        if (!$node) {
            return null;
        }

        $instance = new self();

        $instance->x = $node->getAttribute('x');
        $instance->y = $node->getAttribute('y');

        return $instance;
    }
}
